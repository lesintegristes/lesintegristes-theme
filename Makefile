GEOCITY_URL="http://www.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz"
PLUGINS_PATH=../../plugins
PLUGINS_LIST=advanced-excerpt contact-form-7 really-simple-captcha
OK_COLOR="\x1b[32;01m"
NO_COLOR="\x1b[0m"

# JS files
JS_FINAL_MAIN = scripts/main-min.js
JS_FINAL_SINGLE = scripts/single-min.js
JS_TARGETS = scripts/jquery.cookies.2.2.0.js \
             scripts/main.js \
             scripts/prism.js \
             scripts/single.js
JS_MINIFIED = $(JS_TARGETS:.js=.min.js)

# Binaries
UGLIFY_BIN = uglifyjs

all: plugins geolitecity js

geolitecity:
	@echo "Downloading the GeoLiteCity file..."
	curl -o GeoLiteCity.dat.gz ${GEOCITY_URL}
	-gunzip GeoLiteCity.dat.gz
	rm GeoLiteCity.dat.gz
	@if [ -f GeoLiteCity.dat ]; then \
	mv GeoLiteCity.dat ./weather_service/; \
	fi
	@echo "Done."

plugins:
	@echo $(OK_COLOR)Installing the required plugins...$(NO_COLOR)
	@for PLUGIN in $(PLUGINS_LIST); do \
	echo $(OK_COLOR)Installing $${PLUGIN}...$(NO_COLOR); \
	curl -o $$PLUGIN.zip http://downloads.wordpress.org/plugin/$$PLUGIN.zip; \
	unzip -q ./$$PLUGIN.zip && rm ./$$PLUGIN.zip; \
	mv ./$$PLUGIN "${PLUGINS_PATH}/$$PLUGIN"; \
	rm -rf ./$$PLUGIN; \
	done

# Gettext
GETTEXT_DIR=./languages
GETTEXT_TPL=lesintegristes.pot
i18n: i18n-pot i18n-mo i18n-po

i18n-pot:
	# Updates the template
	find . -iname "*.php" | xargs xgettext --keyword=__ --keyword=_e --keyword=_x:2c,1 --language=php \
		--default-domain=lesintegristes --output="${GETTEXT_DIR}/${GETTEXT_TPL}" --package-name="Les intégristes Theme" \
		--package-version="1" --copyright-holder="Les intégristes" --msgid-bugs-address="bonjour@pierrebertet.net"

i18n-po:
	# Merge the template in the .po file
	msgmerge --no-fuzzy-matching --backup=off -s -U "${GETTEXT_DIR}/fr_FR.po" "${GETTEXT_DIR}/${GETTEXT_TPL}"

i18n-mo:
	# Convert the .po to .mo
	msgfmt -c -v -o "${GETTEXT_DIR}/fr_FR.mo" "${GETTEXT_DIR}/fr_FR.po"

# JavaScript
js: $(JS_FINAL_MAIN) $(JS_FINAL_SINGLE)

$(JS_FINAL_MAIN): scripts/jquery.cookies.2.2.0.min.js scripts/main.min.js
	cat $^ >$@
	rm -f $^
$(JS_FINAL_SINGLE): scripts/prism.min.js scripts/single.min.js
	cat $^ >$@
	rm -f $^

%.min.js: %.js
	$(UGLIFY_BIN) -o $@ $<
	echo >> $@

clean:
	rm -f $(JS_MINIFIED)

.PHONY: geolitecity plugins js clean