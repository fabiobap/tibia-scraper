This is a boss/server scraper for tibia.com using laravel 5.8.

The code is gonna retrieve all servers names and bosses sightings automatically.

At first this was a personal project I made for myself to keep track of bosses so I could always get them and I did for 2~3 years back in 2012 (before boss hunting was cool), but since I don't even play anymore why not share it?

I won't share the average days of their sightings thought. It's not hard to get them it's just repetitive and boring. If I could do it and I'm not any statistics genius or anything :P

For this project to work properly you have to follow every step right:

1. You get all server names. ("/servers")
2. You add the boss you want to get from tibia.com, you add a name and upload an image(get image from wiki idk, your call), ex: Dharalion ("/bosses")
3. You get all sightings for the existing creatures of your database in that day for every server also in the database. ("/sightings")
4. You make a base stats for every boss in database. It's how the prediction work, that's where you need some previous information( I recommend searching for these records in any other sighting websites such as [a link](https://guildstats.eu/bosses). You gotta add min, max and avg days that the boss show up, ex: Dharalion is min:3,avg:5,max:7) ("/predictions/base")
5. And finally you run the predictions part, it will make a record for that boss in every server based on the data from the base stats, it will also calculate automatically the next probable sighting based on avgDays. Even if there's no sighting at first it will create a record for that boss in every server and when you click to update if there's any new sighting it will automatically update the next sighting. ("/predictions")

<p>Obs: As since this is a scraper it may not be working(07/06/2019) when you clone this project, cipsoft could change links and stuff( as they did 3x while I was doing it, annoying lol), but I think the code is pretty clear in that part you can check all of it separately under Services (AutomaticBossSightingCreator and AutomaticServerCreator).</p>
<p>Scraping tibia.com is not all sunshine and rainbows, but I did my best.</p>
