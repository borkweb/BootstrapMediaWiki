# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

BootstrapMediaWiki is a responsive MediaWiki skin that integrates Bootstrap 3 framework. It's designed to provide modern, mobile-friendly styling for MediaWiki installations.

## Development Commands

### Build and Testing
```bash
# Install dependencies
npm install
composer install

# Run all tests (linting for JS, JSON, CSS, PHP)
npm test

# Individual linting tasks
grunt jshint      # JavaScript linting
grunt jsonlint    # JSON validation
grunt banana      # i18n file validation
grunt stylelint   # CSS/Less linting

# PHP linting and coding standards
composer test
composer fix      # Auto-fix PHP coding standard issues
```

### Common Development Tasks
```bash
# Check PHP syntax
composer lint

# Fix PHP coding standards violations
composer fix

# Run specific PHP CodeSniffer checks
vendor/bin/phpcs -p -s
```

## Architecture Overview

### Core Components

1. **Skin Registration**: The skin is registered via `skin.json` which defines:
   - ResourceLoader modules for CSS/JS
   - Configuration variables
   - Message keys for i18n
   - Hook handlers

2. **Template System**: 
   - `includes/SkinBootstrapMediaWiki.php` - Main skin class handling initialization
   - `includes/BootstrapMediaWikiTemplate.php` - Template class responsible for HTML output
   - Uses MediaWiki's BaseTemplate pattern

3. **Styling Architecture**:
   - Bootstrap 3 CSS framework (loaded via ResourceLoader)
   - Custom Less files in `resources/` compiled to CSS
   - Font Awesome 5 for icons
   - Extension-specific overrides in `resources/extensions/`

### Key Implementation Patterns

1. **Navigation Building**: The template dynamically builds navigation menus from MediaWiki sidebar configuration and custom navbar/footer pages.

2. **Responsive Design**: Uses Bootstrap's grid system and responsive utilities throughout the template.

3. **Customization Points**:
   - Wiki pages: `MediaWiki:Bootstrap-skin-navbar` and `MediaWiki:Bootstrap-skin-footer`
   - LocalSettings.php configuration via `$wgBootstrapSkinOptions`
   - Custom CSS/JS files can be added via configuration

### Important Files

- `skin.json` - Skin registration and ResourceLoader module definitions
- `includes/BootstrapMediaWikiTemplate.php` - Main template logic for rendering HTML
- `resources/bootstrap-mediawiki.less` - Primary custom styling
- `i18n/en.json` - English message strings

## MediaWiki Integration Points

1. **Hooks**: The skin uses standard MediaWiki hooks like `SkinTemplateOutputPageBeforeExec`
2. **Parser Functions**: Supports `#submenudynamic` for dynamic menu generation
3. **Message System**: All user-facing text uses MediaWiki's i18n system

## Testing Approach

- **PHP**: MediaWiki coding standards via phpcs
- **JavaScript**: JSHint with jQuery environment
- **CSS/Less**: Stylelint with MediaWiki configuration
- **i18n**: Banana checker ensures message files are valid

When modifying the skin, ensure all linting passes before committing changes.