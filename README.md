# surl
Simple url shortener using Symfony

1.Copy repo to server
2.Install using composer
3.set DB in .env eg) DATABASE_URL=mysql://surl:surl@localhost:3306/surl?serverVersion=10.3.17-MariaDB
4.run 'php bin/console doctrine:migrations:migrate'
(Schema included in repo if you would perfer setting up manualy)

An example site is available at http://surl.chrisjlock.com/
