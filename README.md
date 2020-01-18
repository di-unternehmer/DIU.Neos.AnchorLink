# DIU.Neos.AnchorLink

Extends the Neos CKE5 linkeditor with server-side resolvable anchor links.

![anchorlink](https://user-images.githubusercontent.com/837032/72664973-de351880-3a14-11ea-8d2b-a379b7c7bb47.gif)

## Installation

1. Install the package: `composer require diu/neos-anchorlink`

2. Enable additional linking options with such config:

```
"Neos.NodeTypes.BaseMixins:TextMixin": # Or other nodetype
  properties:
    text:
      ui:
        inline:
          editorOptions:
            linking:
              anchorLink: true
```

3. Create a class implementing `AnchorLinkResolverInterface` that would return an array of options for the link anchor selector and configure it in `Objects.yaml` like this:

```
'DIU\Neos\AnchorLink\Controller\AnchorLinkController':
  properties:
    resolver:
      object: Your\Custom\AnchorLinkResolver
```

## Development

If you need to adjust anything in this package, just do so and then rebuild the code like this:

```
cd Resources/Private/AnchorLink
yarn && yarn build
```

And then commit changed filed including Plugin.js
