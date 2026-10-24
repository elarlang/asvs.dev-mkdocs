#!/bin/bash

echo "NEEDS REWRITE"
exit

echo '# UPDATE'
# owasp-md-export repost
#sh 50update.sh
# php update.php --owasp-repo=asvs-v5.0.0 --update --export=requirement-json > ../ctfm-data/standard/asvs_500.json
# php update.php --owasp-repo=asvs-v5.0.0 --validate

read -p "Valid? " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

echo '# asvs.dev'
cd ../mkdocs-asvs/

php rebuild-content-input.php
sh to-live.sh

echo '# MAPPING UPDATE'

cd ../owasp-asvs-modification-label/
#php update_mapping.php # based on v4.0.3 <> v5.0.based

#mkdir -p synctorepo/
#cp mapping_v4.0.3_to_v5.0.0.yml synctorepo/
#cp mapping_v5.0.0_to_v4.0.3.yml synctorepo/
#cp mapping_v5.0.be_to_v5.0.0.yml synctorepo/

php v5_export_mappings.php
php validate.php

#cd xxx/owasp-md-export/tmp-repo-ASVS-master/5.0/mappings/
#git checkout .
#cd -

read -p "Valid? " -n 1 -r
echo    # (optional) move to a new line
if [[ ! $REPLY =~ ^[Yy]$ ]]
then
    exit 1
fi

php v5_export_mappings.php
php export_levels.php
sh v5_mapping_to_live.sh

cd ../owasp-md-export/
