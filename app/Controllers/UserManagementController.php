<?php

namespace App\Controllers;

use CodeIgniter\Shield\Models\UserModel;

class UserManagementController extends BaseAdminController
{
    // Hanya superadmin yang boleh akses halaman ini
    protected string $requiredGroup = 'superadmin';

    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();
        return view('admin/users/index', $data);
    }

    public function create()
    {
        return view('admin/users/form', ['user' => null]);
    }

    public function store()
    {
        $users = auth()->getProvider();

        $username = $this->request->getPost('username');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');
        $group    = $this->request->getPost('group');

        // Validasi basic
        if (empty($username) || empty($email) || empty($password)) {
            return redirect()->back()->with('error', 'Semua field wajib diisi.')->withInput();
        }

        $user = new \CodeIgniter\Shield\Entities\User([
            'username' => $username,
            'email'    => $email,
            'password' => $password,
        ]);

        if (!$users->save($user)) {
            return redirect()->back()->with('error', implode(', ', $users->errors()))->withInput();
        }

        $newUser = $users->findById($users->getInsertID());
        if ($newUser && $group) {
            $newUser->addGroup($group);
        }

        return redirect()->to('/admin/users')->with('success', "User '{$username}' berhasil dibuat dengan grup '{$group}'.");
    }

    public function edit($id)
    {
        $userModel = new UserModel();
        $data['user'] = $userModel->findById($id);
        if (!$data['user']) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        return view('admin/users/form', $data);
    }

    public function update($id)
    {
        $userModel = new UserModel();
        $user = $userModel->findById($id);

        if (!$user) throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();

        // Jangan izinkan edit akun sendiri dari sini
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat mengedit akun Anda sendiri dari sini.');
        }

        $updateData = [];
        if ($this->request->getPost('username')) $updateData['username'] = $this->request->getPost('username');
        if ($this->request->getPost('email'))    $updateData['email']    = $this->request->getPost('email');
        if ($this->request->getPost('password')) $updateData['password'] = $this->request->getPost('password');

        $userModel->save(array_merge(['id' => $id], $updateData));

        // Update grup
        $group = $this->request->getPost('group');
        if ($group) {
            // Hapus semua grup lama lalu tambahkan yang baru
            foreach ($user->getGroups() as $oldGroup) {
                $user->removeGroup($oldGroup);
            }
            $user->addGroup($group);
        }

        return redirect()->to('/admin/users')->with('success', 'Data user berhasil diperbarui.');
    }

    public function delete($id)
    {
        if ($id == auth()->id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun Anda sendiri.');
        }

        $userModel = new UserModel();
        $userModel->delete($id, true); // hard delete

        return redirect()->to('/admin/users')->with('success', 'User berhasil dihapus.');
    }
}
