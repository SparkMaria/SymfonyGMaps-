symfony.loc
===========

1.composer update
2.php bin/console doctrine:schema:create
3.permissions
  HTTPDUSER=$(ps axo user,comm | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1)
  sudo setfacl -dR -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
  sudo setfacl -R -m u:"$HTTPDUSER":rwX -m u:$(whoami):rwX var
