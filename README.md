# VentMob and Revolt Gaming Memorial Website

This is the source-code for the VentMob and Revolt Gaming memorial website.


## Contributions

Any contributions to this project are much appreciated, whether you are just posting an issue about some missing/incorrect information or creating a pull-request with enhancements.


> Do you have any screenshots, videos or other content of VentMob or Revolt Gaming fun? Thanks for dropping them in an issue @ [github.com/thejjokerr/ventmob-memorial/issues](https://github.com/thejjokerr/ventmob-memorial/issues)!


## Installation

1.  Clone this repo to your webserver

2.  Point your incoming web-traffic to the `public/` directory

3.  You're ready to use/test this site.


### Docker Notes

To launch this on a webserver in a docker container with [docker-letsencrypt-nginx-proxy-companion](https://github.com/evertramos/docker-compose-letsencrypt-nginx-proxy-companion):

#### With a volume:
Run this in the root of this git repo:
```
docker run -d \
	   --name website_ventmob \
	   -v "$PWD/public/":/app/ \
	   -e VIRTUAL_HOST=ventmob.com \
           -e LETSENCRYPT_HOST=ventmob.com \
           -e LETSENCRYPT_EMAIL=youremail@domain.tld \
           --network=webproxy \	
	   k0st/alpine-apache-php
```

#### Without a volume:
1. Build the `Dockerfile` using:

   ```
   docker build -t my-httpd .
   ```

2. Run the container with:
   ```
   docker run -d -e VIRTUAL_HOST=ventmob.com \
              -e LETSENCRYPT_HOST=ventmob.com \
              -e LETSENCRYPT_EMAIL=youremail@domain.tld \
              --network=webproxy \
              --name website_ventmob \
              my-httpd
   ```


## Notes

* By default a `.htaccess` is included for those who do not have access to apache config files. If you do have access then you should make these changes in the appropriate apache configuration. If you do want to use the `.htaccess`, make sure apache has AllowOverride set appropriately.
