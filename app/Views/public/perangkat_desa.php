<?= $this->extend('layout/public') ?>
<?= $this->section('content') ?>

<section class="max-w-7xl mx-auto px-4 sm:px-6 py-20 md:py-28">

    <!-- Header -->
    <div class="text-center mb-16 md:mb-20 anime-fade-up opacity-0">
        <h2 class="text-sm font-bold tracking-widest text-earth-600 uppercase mb-3">Struktur Pemerintahan</h2>
        <h1 class="text-4xl md:text-6xl font-heading font-extrabold text-forest-900 mb-4">Perangkat Desa</h1>
        <div class="w-24 h-1 bg-earth-400 mx-auto rounded-full mb-6"></div>
        <p class="text-earth-700 max-w-2xl mx-auto text-lg">Mengenal para pelayan masyarakat yang berdedikasi membangun Desa Lubuk Lagan.</p>
    </div>

    <?php
    $structureMode = $settings['officer_structure_mode'] ?? 'dynamic';
    $structureImage = $settings['officer_structure_image'] ?? '';
    ?>

    <?php if ($structureMode === 'photo' && !empty($structureImage)): ?>
        <!-- SINGLE PHOTO MODE -->
        <div class="max-w-5xl mx-auto bg-white rounded-[2rem] shadow-sm border border-earth-100 p-4 md:p-8 anime-fade-up opacity-0">
            <div class="relative overflow-hidden rounded-2xl border border-gray-100 shadow-inner">
                <img src="<?= base_url($structureImage) ?>" alt="Struktur Organisasi Perangkat Desa" class="w-full h-auto object-contain mx-auto" loading="lazy">
            </div>
        </div>
    <?php else: ?>

        <?php if (empty($officers)): ?>
        <div class="text-center py-20 text-earth-400">
            <p class="text-xl">Data perangkat desa belum tersedia.</p>
        </div>
        <?php else: ?>

        <!-- ORG CHART TREE -->
        <div class="org-chart-wrapper overflow-x-auto pb-8">
            <div class="org-chart" id="orgChart">
            <?php
            // Build tree from flat list
            $map   = [];
            $roots = [];
            foreach ($officers as $o) { $o->children = []; $map[$o->id] = $o; }
            foreach ($map as $o) {
                if ($o->parent_id && isset($map[$o->parent_id])) {
                    $map[$o->parent_id]->children[] = &$map[$o->id];
                } else {
                    $roots[] = &$map[$o->id];
                }
            }

            // Recursive render
            function renderOrgNode($node, $isRoot = false) {
                $levelColors = ['', '#1d4ed8','#16a34a','#d97706','#7c3aed','#db2777'];
                $levelBg     = ['', '#eff6ff','#f0fdf4','#fffbeb','#f5f3ff','#fdf2f8'];
                $lc = $levelColors[$node->level] ?? '#6b7280';
                $lb = $levelBg[$node->level] ?? '#f9fafb';
                $hasChildren = !empty($node->children);
                ?>
                <li>
                    <div class="org-node <?= $isRoot ? 'org-node--root' : '' ?> anime-card opacity-0"
                         style="--node-color: <?= $lc ?>; --node-bg: <?= $lb ?>">
                        <!-- Photo -->
                        <div class="org-node__photo" style="border-color: <?= $lc ?>">
                            <?php if ($node->photo): ?>
                                <img src="<?= base_url($node->photo) ?>" alt="<?= esc($node->name) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="org-node__photo-placeholder">
                                    <svg viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/></svg>
                                </div>
                            <?php endif; ?>
                        </div>
                        <!-- Info -->
                        <div class="org-node__info">
                            <span class="org-node__level-badge" style="background: <?= $lc ?>20; color: <?= $lc ?>; border-color: <?= $lc ?>40">
                                Level <?= $node->level ?>
                            </span>
                            <h3 class="org-node__name"><?= esc($node->name) ?></h3>
                            <p class="org-node__position"><?= esc($node->position) ?></p>
                            <?php if ($node->quote): ?>
                            <p class="org-node__quote">"<?= esc($node->quote) ?>"</p>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if ($hasChildren): ?>
                    <ul>
                        <?php foreach ($node->children as $child): ?>
                            <?php renderOrgNode($child); ?>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </li>
                <?php
            }
            ?>

            <ul>
                <?php foreach ($roots as $root): ?>
                    <?php renderOrgNode($root, true); ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>

    <?php endif; ?>
    <?php endif; ?>
</section>

<style>
/* ===== ORG CHART CORE ===== */
.org-chart-wrapper {
    padding: 2rem 1rem;
}
.org-chart,
.org-chart ul {
    padding: 0;
    margin: 0;
    list-style: none;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.org-chart ul {
    padding-top: 2rem;
    position: relative;
    display: flex;
    flex-direction: row;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
}

/* Vertical line DOWN from parent node */
.org-chart ul::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 2rem;
    background: linear-gradient(to bottom, #d1d5db, #d1d5db);
}

/* Horizontal line connecting siblings */
.org-chart ul > li {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    padding-top: 0;
}
.org-chart ul > li::before {
    content: '';
    position: absolute;
    top: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 1.5rem;
    background: #d1d5db;
}
/* Horizontal line across siblings */
.org-chart ul > li:not(:only-child)::after {
    content: '';
    position: absolute;
    top: 0;
    width: 50%;
    height: 2px;
    background: #d1d5db;
}
.org-chart ul > li:not(:only-child):first-child::after { right: 0; }
.org-chart ul > li:not(:only-child):last-child::after  { left: 0; }
.org-chart ul > li:not(:first-child):not(:last-child)::after {
    width: 100%; left: 0;
}

/* ===== NODE CARD ===== */
.org-node {
    background: var(--node-bg, #f9fafb);
    border: 2px solid color-mix(in srgb, var(--node-color, #6b7280) 20%, transparent);
    border-radius: 1.5rem;
    padding: 1.5rem 1.25rem;
    text-align: center;
    width: 175px;
    position: relative;
    transition: transform 0.2s ease, box-shadow 0.2s ease;
    cursor: default;
}
.org-node:hover {
    transform: translateY(-4px);
    box-shadow: 0 20px 40px -10px color-mix(in srgb, var(--node-color, #6b7280) 25%, transparent);
}
.org-node--root {
    width: 210px;
    padding: 2rem 1.5rem;
    border-radius: 2rem;
    box-shadow: 0 10px 40px -8px color-mix(in srgb, var(--node-color, #1d4ed8) 30%, transparent);
}

.org-node__photo {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    margin: 0 auto 0.75rem;
    border: 3px solid var(--node-color, #6b7280);
    background: #fff;
}
.org-node--root .org-node__photo {
    width: 100px;
    height: 100px;
}
.org-node__photo img {
    width: 100%; height: 100%; object-fit: cover;
}
.org-node__photo-placeholder {
    width: 100%; height: 100%;
    display: flex; align-items: center; justify-content: center;
    background: #f1f5f9;
}
.org-node__photo-placeholder svg {
    width: 40%; height: 40%;
    color: #cbd5e1;
}

.org-node__level-badge {
    display: inline-block;
    font-size: 0.65rem;
    font-weight: 700;
    padding: 0.2rem 0.6rem;
    border-radius: 999px;
    border: 1px solid;
    margin-bottom: 0.4rem;
    letter-spacing: 0.05em;
}
.org-node__name {
    font-size: 0.875rem;
    font-weight: 800;
    color: #1e293b;
    margin-bottom: 0.25rem;
    line-height: 1.3;
}
.org-node--root .org-node__name {
    font-size: 1rem;
}
.org-node__position {
    font-size: 0.75rem;
    color: var(--node-color, #64748b);
    font-weight: 600;
    margin-bottom: 0.25rem;
}
.org-node__quote {
    font-size: 0.68rem;
    color: #94a3b8;
    font-style: italic;
    margin-top: 0.4rem;
    line-height: 1.4;
}

/* Mobile: stack vertically */
@media (max-width: 640px) {
    .org-chart ul {
        flex-direction: column;
        align-items: center;
        gap: 0;
    }
    .org-chart ul::before {
        height: 100%;
    }
    .org-chart ul > li::after { display: none; }
    .org-node { width: 90vw; max-width: 280px; }
    .org-node--root { width: 90vw; max-width: 300px; }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    anime({
        targets: '.anime-fade-up',
        translateY: [40, 0],
        opacity: [0, 1],
        duration: 900,
        easing: 'easeOutCubic'
    });
    anime({
        targets: '.anime-card',
        scale: [0.85, 1],
        opacity: [0, 1],
        delay: anime.stagger(80, {start: 300}),
        duration: 600,
        easing: 'easeOutBack'
    });
});
</script>

<?= $this->endSection() ?>
