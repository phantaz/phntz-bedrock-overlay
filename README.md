# Phantaz Bedrock Overlay

[![CI](https://github.com/phantaz/phntz-bedrock-overlay/actions/workflows/ci.yml/badge.svg)](https://github.com/phantaz/phntz-bedrock-overlay/actions/workflows/ci.yml)
[![License: MIT](https://img.shields.io/badge/License-MIT-22c55e.svg)](LICENSE)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3%2B-777bb4.svg)](https://www.php.net/)
[![Composer 2](https://img.shields.io/badge/Composer-2-885630.svg)](https://getcomposer.org/)

An interactive overlay for a clean [Roots Bedrock](https://roots.io/bedrock/) project. It installs a curated Bricks stack, generates a project-named child theme, configures environment-backed licenses, and optionally initializes the WordPress database.

Bedrock is never copied or forked. Create the official project first, then apply the overlay with one command.

## Quick start

### DDEV

```bash
mkdir client-site && cd client-site
ddev config --project-type=wp-bedrock --php-version=8.5
ddev start
ddev composer create-project roots/bedrock

bash <(curl -fsSL https://raw.githubusercontent.com/phantaz/phntz-bedrock-overlay/main/install)
```

The overlay detects DDEV and uses `ddev composer` and `ddev wp` automatically.

### Regular server

```bash
composer create-project roots/bedrock client-site
cd client-site

bash <(curl -fsSL https://raw.githubusercontent.com/phantaz/phntz-bedrock-overlay/main/install)
```

The server workflow uses the system Composer and WP-CLI commands.

## What it does

- Requires Composer 2 and authenticates with the private WP Box P2 repository.
- Installs Bricks plus an interactive selection of ACF PRO, HappyFiles PRO, Bricksforge, Perfmatters, SEOPress PRO, and Motion.page.
- Adds an isolated `config/project.php` before Bedrock's `Config::apply()` call.
- Configures `WP_MEMORY_LIMIT` and `WP_MAX_MEMORY_LIMIT`.
- Supports environment-backed ACF, Bricks, Perfmatters, and SEOPress license keys.
- Generates production database settings and cryptographic salts outside DDEV.
- Creates `web/app/themes/<project-slug>-bricks-child` from the included child-theme template.
- Protects the project-named child theme from same-slug WordPress.org replacements.
- Copies separate child, Bricks parent, and backup theme screenshots.
- Optionally installs WordPress, activates the generated theme and plugins, and opens local wp-admin.

Only the Composer-installed `web/app/themes/bricks/` directory is added to the generated project's `.gitignore`.

## WP Box authentication

The installer asks for a WP Box Bearer token and stores it in the generated project's ignored `auth.json`:

```bash
composer config --auth bearer.api.phntz.com YOUR_TOKEN
composer config repositories.wp-box composer https://api.phntz.com/packages.json
```

For automation, pass the token without a prompt:

```bash
WP_BOX_COMPOSER_TOKEN="$WP_BOX_COMPOSER_TOKEN" \
  bash <(curl -fsSL https://raw.githubusercontent.com/phantaz/phntz-bedrock-overlay/main/install)
```

Never commit `auth.json`, `.env`, license keys, or the WP Box token.

## Generated environment values

```dotenv
WP_MEMORY_LIMIT='256M'
WP_MAX_MEMORY_LIMIT='512M'

ACF_PRO_LICENSE=''
BRICKS_LICENSE_KEY=''
PERFMATTERS_LICENSE_KEY=''
SEOPRESS_LICENSE_KEY=''
```

Bricksforge and HappyFiles are omitted because they do not natively consume environment-backed WordPress constants.

## Child theme

The generated theme includes explicit modules for assets, Bricks custom elements, and integrations:

```text
assets/
elements/
inc/
  elements.php
  enqueue.php
  tweaks.php
functions.php
style.css
```

Custom Bricks elements are registered from `elements/class-<slug>.php` at `init` priority 11. The Themes screen uses `screenshot-parent.png` for Bricks and `screenshot-backup.png` for every other inactive theme. FlyingPress keeps its timestamped footprint behavior.

The directory and stylesheet slug are generated deterministically as `<project-slug>-bricks-child`; only the project slug is requested. For example, project `mediator` becomes `web/app/themes/mediator-bricks-child`, while its display name remains `Mediator`. The explicit Bricks suffix avoids public-theme slug collisions, a custom `Update URI` prevents WordPress.org replacements, and the installer validates a private generation marker before activation.

## Reproducible releases

Use `main` while developing. Pin both the bootstrap and downloaded archive for client projects:

```bash
PHNTZ_OVERLAY_VERSION=v1.0.0 \
  bash <(curl -fsSL https://raw.githubusercontent.com/phantaz/phntz-bedrock-overlay/v1.0.0/install)
```

To test a local checkout without downloading an archive:

```bash
PHNTZ_OVERLAY_SOURCE=/path/to/phntz-bedrock-overlay \
  /path/to/phntz-bedrock-overlay/install
```

## Requirements

- Bash
- curl, tar, OpenSSL, awk, sed
- Composer 2
- PHP 8.3 or newer
- DDEV for the local workflow
- WP-CLI when initializing a non-DDEV WordPress database

## License

[MIT](LICENSE)
