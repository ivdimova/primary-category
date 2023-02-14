<?php
/**
 * Primary Category Setup.
 */

namespace PrimaryCategory;

require_once __DIR__ . '/primary-category-admin.php';
require_once __DIR__ . '/primary-category-shortcode.php';
require_once __DIR__ . '/primary-category-db.php';

Admin\bootstrap();
Shortcode\bootstrap();
