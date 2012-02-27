BOOTSTRAP = ./bootstrap/css/bootstrap.css
BOOTSTRAP_LESS = ./bootstrap-git/less/bootstrap.less
BOOTSTRAP_RESPONSIVE = ./bootstrap/css/bootstrap-responsive.css
BOOTSTRAP_RESPONSIVE_LESS = ./bootstrap-git/less/responsive.less
LESS_COMPRESSOR ?= `which lessc`
WATCHR ?= `which watchr`

#
# BUILD SIMPLE BOOTSTRAP DIRECTORY
# lessc & uglifyjs are required
#

mediawiki: bootstrap
	cat bootstrap/js/bootstrap.js js/jquery-dotimeout/jquery.ba-dotimeout.js js/behavior.js > js/site.js
	uglifyjs -nc js/site.js > js/site.min.js

bootstrap: 
	rm -rf bootstrap
	mkdir -p bootstrap
	mkdir -p bootstrap/img
	mkdir -p bootstrap/css
	mkdir -p bootstrap/js
	cp bootstrap-git/img/* bootstrap/img/
	lessc ${BOOTSTRAP_LESS} > bootstrap/css/bootstrap.css
	lessc --compress ${BOOTSTRAP_LESS} > bootstrap/css/bootstrap.min.css
	lessc ${BOOTSTRAP_RESPONSIVE_LESS} > bootstrap/css/bootstrap-responsive.css
	lessc --compress ${BOOTSTRAP_RESPONSIVE_LESS} > bootstrap/css/bootstrap-responsive.min.css
	cat bootstrap-git/js/bootstrap-transition.js bootstrap-git/js/bootstrap-alert.js bootstrap-git/js/bootstrap-button.js bootstrap-git/js/bootstrap-carousel.js bootstrap-git/js/bootstrap-collapse.js bootstrap-git/js/bootstrap-dropdown.js bootstrap-git/js/bootstrap-modal.js bootstrap-git/js/bootstrap-tooltip.js bootstrap-git/js/bootstrap-popover.js bootstrap-git/js/bootstrap-scrollspy.js bootstrap-git/js/bootstrap-tab.js bootstrap-git/js/bootstrap-typeahead.js > bootstrap/js/bootstrap.js

#
# WATCH LESS FILES
#

watch:
	echo "Watching less files..."; \
	watchr -e "watch('less/.*\.less') { system 'make' }"


.PHONY: dist docs watch
