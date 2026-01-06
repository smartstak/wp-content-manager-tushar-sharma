# WP Content Manager – Promo Blocks - Tushar Sharma

## Overview
This plugin provides a dynamic promo block system for managing time-bound promotional content such as offers, CTAs.

## Setup instructions
1. Upload plugin to `/wp-content/plugins`
2. Run `composer dump-autoload`
3. Activate plugin
4. Configure settings under **Settings → Dynamic Content**
5. Go to **Promo Blocks** -> **Add New Promo Block**
6. Insert Shortcode **[dynamic_promo]** wherever you want to display **Promo Blocks**
7. That's it.

## Shortcode
- [dynamic_promo]

## Features
- Custom Post Type: Promo Blocks
- Expiry-based visibility
- Priority ordering
- Shortcode & REST API support
- Transient caching
- REST API Approach for AJAX Loading
- Gutenberg block wrapper - NOT TESTED.
- WP_CLI custom command included to flush Promo block cache **wp wpcm flush-promos-cache**


## REST API
- /wp-json/dcm/v1/promos
- ?rendered=1 **return HTML when ajax loading enabled**

## Performance Optimizations
- Transient-based caching
- Conditional asset loading
- Lazy-loaded images
- Cache invalidation on post save
- Followed **PSR-4** autoloading for better class loading.
- **BEM CSS Structure** followed for Faster Browser Rendering, improved Caching Efficiency
- Also used **PHPCS** with other packages for consistent coding standard, security

## Security
- Nonce verification
- Capability checks
- Sanitized inputs
- Escaped outputs

## Assumptions
- Promo blocks are only managed by admin
- Expiry date is mandatory
- Display priority lower number = higher priority

## Possible Improvements
- Full Gutenberg editor UI