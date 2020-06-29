
MIT licence
Copyright 2020

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.

---

Projet lié à https://github.com/Bolbe/trapta

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
