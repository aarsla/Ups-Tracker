# UPS Tracker 
 
## Description

Wordpress plugin for tracking UPS packages.
 
## Requirements
 
UPS API credentials: https://www.ups.com/upsdeveloperkit

## Installation
 
1. Upload `Ups Tracker` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your credentials through Ups Tracking settings menu
4. Add `[ups-tracking-form]` shortcode to any page

## Frequently Asked Questions
 
#### Where do I get UPS API access from?
 
https://www.ups.com/upsdeveloperkit

#### How do I modify output?

Check `Frontend/ContactForm.php` `formatResponse()` method

## Screenshots
 
### Query Form
![Query Form](https://raw.githubusercontent.com/aarsla/ups-tracker/master/assets/screenshot-1.png "Query Form")

### API Response
![API Response](https://raw.githubusercontent.com/aarsla/ups-tracker/master/assets/screenshot-2.png "API Response")

### Plugin Settings
![Plugin Settings](https://raw.githubusercontent.com/aarsla/ups-tracker/master/assets/screenshot-3.png "Plugin Settings")

