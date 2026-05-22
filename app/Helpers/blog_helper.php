<?php

/**
 * Extract thumbnail for a blog post.
 * Priority: explicit thumbnail field → first <img> in content → null
 */
function blog_thumbnail(object $blog): ?string
{
    // 1. Explicit thumbnail set by editor
    if (!empty($blog->thumbnail)) {
        return $blog->thumbnail;
    }

    // 2. Auto-extract first <img src="..."> from content
    if (!empty($blog->content)) {
        if (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/', $blog->content, $m)) {
            return $m[1];
        }
    }

    return null;
}
