score-trapta

Créer la table des utilisateurs dans une base de données Mysql. Le fichier de creation est usertable.sql

Editer le fichier dbconnect.php, et remplacer la ligne:

$db=mysqli_connect("mysql-server","db-user","db-password","db-name");

par les valeurs de votre base de données.

Lors d'un ajout d'utilisateur, il faut ajouter une ligne dans la table usertable de la base mysql et dupliquer le répertoire TRAPTA et le renommer en lui donnant le nom de l'utilisateur. Par example, l'utilisateur CD255 veut poster ses résultats, il faut créer une ligne qui ressemblera à:

```
Username     Password  
CD255        cd255password 
```

Créer le répertoire CD255 au même niveau que le répertoire TRAPTA et y copier tout le contenu du répertoire TRAPTA.
