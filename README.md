## How To Use
On commence par faire son .env.local dans lequel on met les infos de connexion
1. `bin/console do:da:dr --force` on drop la base
2. `bin/console do:da:cr` on crée la base
3. `bin/console do:mi:mi` on fait le migrate
4. `bin/console do:fi:lo` on charge les fixtures
5. On crée le couple clef privée/clef publique 
```
mkdir -p config/jwt
openssl genpkey -out config/jwt/private.pem -aes256 -algorithm rsa -pkeyopt rsa_keygen_bits:4096
openssl pkey -in config/jwt/private.pem -out config/jwt/public.pem -pubout
```
6. On modifie le .env.local pour y rajouter la `JWT_PASSPHRASE=passphrase` en remplaçant passphrase par ce que vous avez mis lors de la génération de la clef privée
