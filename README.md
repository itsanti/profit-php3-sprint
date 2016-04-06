## Интенсив «PHP-3: Повышение квалификации»
[страница интенсива](http://pr-of-it.ru/sprints/10.html)
### Д3 №1
`DocumentRoot /vagrant/current/public`
### Д3 №2
1-2: коммит "move config to build. db password from cli"

3-4: коммит "create migrations"

5: есть несколько вариантов:
* для миграций с удалением данных можно делать бэкап в `up()`
с последующим восстановлением его в `down()`
* монжно просто выкидывать исключение
* [SO на тему](http://stackoverflow.com/questions/621257/rails-is-it-bad-to-have-an-irreversible-migration)