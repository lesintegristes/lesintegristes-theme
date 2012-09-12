GEOCITY_URL="http://www.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz"
PLUGINS_PATH=../../plugins
PLUGINS_LIST=advanced-excerpt contact-form-7 really-simple-captcha
OK_COLOR="\x1b[32;01m"
NO_COLOR="\x1b[0m"

all: plugins geolitecity

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

.PHONY: geolitecity plugins