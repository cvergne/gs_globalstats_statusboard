## "Last 3 months Browser stats" for Panic's Status Board
> from [Statcounter](http://gs.statcounter.com/)

A simple PHP script to display the last 3 months browser stats (partially combined) on your Panic's Status Board.

The data is returned in JSON, to be used as native Graph in Panic's Status Board.

### Install
Copy the `globalstats_statusboard` folder on your own server ( _it requires PHP to work_ ).  
Copy the url, like : `http://yourdomain.com/path/to/globalstats_statusboard/`

### Parameter
You can choose the number of columns to display. 
* **default** is `5`
* set `-1` to remove limit

You can set the limit in the url : `/globalstats_statusboard/?limit=-1`

### Cache
Widget cache result on the server, in the same place that the index file.  
Cache time limit is 18 hours, like the auto-refresh time (in Status Board 1.1+).

### Preview
![Preview of Globalstats Panic's Status Board widget](https://dl.dropboxusercontent.com/u/2185088/gs_statusboard.png)

### License
**Script:** Copyright 2013 Christophe VERGNE  
**Data:** Copyright 2013 Statcounter
