mkdocs -q build -f tmp-mkdocs-content-input/mkdocs.yml -d ../wwwroot/

rm wwwroot/sitemap.xml*
cp custom-assets/robots.txt wwwroot/
