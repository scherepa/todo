# Todos
## Current version is 2

## What is done

* in both versions create, update, delete all via ajax but different way. no refresh as desired

* there is no refresh in both versions. on version 2 search and filter maybe applyed

* on version 2 more separation into small components allthow all js left on module(I'm mostly backend) and feel not comfortable with it

    * #### remarks

        * on version 1 it is legacy on front(inspired from my 4 years ago first project can be seen on github ecommerce). it was overcomplecated by me... but you need to see progress

        * as have not been asked to make permitions and connect it to user, policy or authorization have not  been created

        * as no figma provided don somehow based on intuition

        * basicaly it could be done with Yajra too(used at work, several years ago but used)

## Missed

* on front error catch and alert
* on front and back in v2 search should be validated and clean...
* fix bootstrap icons
* extract scripts from page on to separate js files in resources... you said public but vite should map(what mixin done before) from resources to public by himself and compiled


## Challenges I've faced during development

* docker on my PC(have to get used to work/fight with it). At work all I had to do run it or add-host... At home? Well everything(here i can not say that i've not used online search/ free chats to understand what to do when and where permitions changed) and docker relevant configurations please do not take into account

* at work mostly used vue, so it was a bit hard


## Possiable improvements

* still need to clean input search for preventing injection(on front and back)
* have not added front validation
* preferable to install pusher or reverb and update on server side event(update/delete/create) via broadcast
* bootstrap icons unfinished initializations
* elastic search could help as search by %[searchString]% will not use any index even if to add
* cache better on redis