### Welcome to the Mgt Developer Toolbar for Magento 1.4.x - 1.7.x!

The Mgt Developer Toolbar for magento is very useful for all developers and frontend guys. 
Many professional developers all over the world use this extension to find possible performance bottlenecks. 
You have an overview of the parse time, memory consumption and number of queries executed. 
It also gives you information about the Controller, Module and Action which is responsible for the current request. 
The advantage for frontend guys should also be mentioned, you get a complete overview how the blocks are rendered and which templates are used.
This makes all block and template changes easier than ever before. 

## DEMO

[Url: http://developertoolbar.mgt-commerce.com/](http://developertoolbar.mgt-commerce.com/)

## INSTALLATION

* copy all files to your magento installation
* Clear the cache in Admin -> System -> Cache Management 
* Go to Admin -> System -> Configuration -> MGT-COMMERCE.COM -> Developer Toolbar -> Settings -> Active -> Yes 
* edit index.php and enable the profiler Varien_Profiler::enable();
* have fun and give feedback :)

## FEATURES

* Professional toolbar for frontend and backend

* Requests: involved controller classes, modules, actions and request parameters

* General Info: website id, website name, store id, store name, storeview id, storeview code, storeview name and configured caching method

* Handles: Displays all handles

* Events/Observer: Shows all events with it's observers

* Blocks: overview of block nesting

* Config: enable/disable frontend hints, inline translation and cache clearing

* PHP-Info: output of phpinfo()

* Profiling: output of Varien_Profiler with function execution time, function count and memory usage

* Additional Information: version information, page execution time and overall memory usage

* DB-Profiler: Number of executed queries, average query length, queries per second, longest query length, longest query and detailed query listing including simple syntax highlighting of SQL


## CHANGELOG

3.0.0

* add function to enable/disable
* add ip restrictions - comma seperated
* show complete template path in nested blocks
* show number of inserts, updates, select, deletes and transactions
* new jquery version 1.7.2 has been added
* cleanup of unused code

2.0.0

*  add handles and events/observers in info block
*  developer toolbar now available for backend

1.5.0

* fixed bug in profiler sort order