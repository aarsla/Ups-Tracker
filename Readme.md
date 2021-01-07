# Tracking for UPS

Wordpress plugin for tracking UPS packages.

## Description

Use your UPS InfoNotice® or tracking number to get the latest package status and estimated delivery date.

**Get Tracking Information and Peace of Mind**

Whether you're receiving one package or shipping hundreds, UPS Tracking provides insight about your shipment's status all along its journey. You'll feel confident and have peace of mind knowing that you have the most up-to-date information when you use our enhanced tracking options.

UPS Tracking offers several ways to track, and provides convenient ways to stay informed of current status, unexpected delays, and ultimately the delivery of your shipment.

## Requirements

UPS API credentials: https://www.ups.com/upsdeveloperkit

## Installation

1. Upload `tracking-for-ups` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add your credentials through Ups Tracking settings menu
4. Add `[ups-tracking-form]` shortcode to any page

## Frequently Asked Questions

#### Where do I get API credentials from?

https://www.ups.com/upsdeveloperkit

#### How do I modify output?

Check `Frontend/ContactForm.php` `formatResponse()` method

## Screenshots

### Query Form

![Query Form](https://raw.githubusercontent.com/aarsla/tracking-for-ups/master/assets/screenshot-1.png "Query Form")

### API Response

![API Response](https://raw.githubusercontent.com/aarsla/tracking-for-ups/master/assets/screenshot-2.png "API Response")

### Plugin Settings

![Plugin Settings](https://raw.githubusercontent.com/aarsla/tracking-for-ups/master/assets/screenshot-3.png "Plugin Settings")

