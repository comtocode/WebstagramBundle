# CTC Webstagram Bundle

## Introduction

This bundle allows you to download instagram RSS feed with webstagram and displaying items on your twig template.

## Configuration

In Yaml file `Ressources/config/parameters.yml` : 

```
# Define prefix uri - Suffix is ID
webstagram.urlPrefix: 'https://web.stagram.com/rss/n/'
```

```
# Your default ID
webstagram.defaultID: 'comtocode'
```
```
# Prefix URI when users click on image (default : https://web.stagram.com/p/)
webstagram.front.urlPrefix: 'https://www.instagram.com/p/'
```

```
# Max item number on front office (Min value : 1 - Max value = 12 )
webstagram.front.maxItem: 6
```

## Import

To import your RSS feed, please run command : 

```
php app/console ctc:webstagram 
```

### Option

``--id='YourInstagramID'`` : Your instagram ID  (example : `comtocode`)


## Display

Insert in your twig file this render controller : 

```twig

{{  render_esi(controller('CTCWebstagramBundle:Webstagram:view')) }}

```

### Option

#### Update instagram ID

You can change instagram ID (name) to avoid default ID is used
```twig
{{  render_esi(controller(
    'CTCWebstagramBundle:Webstagram:view',
    {
        'name': 'comtocode'
   }
)) }}      
```


#### Add description

You need a description below your title ? No problem !

```twig
{{  render_esi(controller(
    'CTCWebstagramBundle:Webstagram:view',
    {
        'description' : 'My amazing description'
    }
)) }}
```

#### Max Item (max 12)

You can define the number of item you need on front office :

```twig
{{  render_esi(controller(
    'CTCWebstagramBundle:Webstagram:view',
    {
        'maxItem': 10
    }
)) }}
```


### Override default template

Finally, you need a specific template or uses your own, you can do it ! (but we suggest you to referring by our template) :

```twig
{{  render_esi(controller(
    'CTCWebstagramBundle:Webstagram:view',
    {
        'template': '@CTCWebstagram/webstagram/view.html.twig'
    }
)) }}
```

#### Example with custom ID, description, maxItem and override Default template

```twig
{{  render_esi(controller(
    'CTCWebstagramBundle:Webstagram:view',
    {
        'name': 'comtocode',
        'description' : 'My amazing description,
        'maxItem' : 10,
        'template': '@CTCWebstagram/webstagram/view.html.twig'
    }
)) }}         
```
