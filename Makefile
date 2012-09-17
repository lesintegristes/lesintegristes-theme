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
             scripts/syntax-highlighter.js \
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
	@echo $(OK_COLOR)Installing lesintegristes-notes...$(NO_COLOR)
	cp "./plugins/lesintegristes-notes.php" "${PLUGINS_PATH}/lesintegristes-notes.php"
	@for PLUGIN in $(PLUGINS_LIST); do \
	echo $(OK_COLOR)Installing $${PLUGIN}...$(NO_COLOR); \
	curl -o $$PLUGIN.zip http://downloads.wordpress.org/plugin/$$PLUGIN.zip; \
	unzip -q ./$$PLUGIN.zip && rm ./$$PLUGIN.zip; \
	mv ./$$PLUGIN "${PLUGINS_PATH}/$$PLUGIN"; \
	rm -rf ./$$PLUGIN; \
	done

# JavaScript
js: $(JS_FINAL_MAIN) $(JS_FINAL_SINGLE)

$(JS_FINAL_MAIN): scripts/jquery.cookies.2.2.0.min.js scripts/main.min.js
	cat $^ >$@
	rm -f $^
$(JS_FINAL_SINGLE): scripts/syntax-highlighter.min.js scripts/single.min.js
	cat $^ >$@
	rm -f $^

%.min.js: %.js
	$(UGLIFY_BIN) -o $@ $<
	echo >> $@

clean:
	rm -f $(JS_MINIFIED)

.PHONY: geolitecity plugins js clean