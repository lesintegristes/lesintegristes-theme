GEOCITY_URL = "http://www.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz"

all: geolitecity

geolitecity:
	@echo "Downloading the GeoLiteCity file..."
	curl -o GeoLiteCity.dat.gz ${GEOCITY_URL}
	gunzip GeoLiteCity.dat.gz
	mv GeoLiteCity.dat ./meteo_service/
	@echo "Done."

.PHONY: geolitecity