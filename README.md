Gamestore

# How to set up Gamestore
- _git clone https://github.com/FearLycan/gamestore.git_
- _git checkout cart_
- _git composer install_
- go to _config_ and rename web-local.php.dist to web-local.php
- go to _config/db.php_ and config your connection to database
- run _php yii migrate_
- run _php yii game/synchronization_
- go and check your page