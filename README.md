# DIU.Neos.AnchorLink

Extends the Neos CKE5 linkeditor with server-side resolvable anchor links.

![anchorlink](https://user-images.githubusercontent.com/837032/72664973-de351880-3a14-11ea-8d2b-a379b7c7bb47.gif)

## Installation

1. Install the package: `composer require diu/neos-anchorlink`

2. Enable additional linking options with such config:

```yaml
"Neos.NodeTypes.BaseMixins:TextMixin": # Or other nodetype
  properties:
    text:
      ui:
        inline:
          editorOptions:
            linking:
              anchorLink: true
```

3. For all content nodetypes that you would like to be able to link to, inherit from `DIU.Neos.AnchorLink:AnchorMixin`, e.g.:

```yaml
Neos.Neos:Content:
  superTypes:
    DIU.Neos.AnchorLink:AnchorMixin: true
```

4. Adjust the rendering for those nodes to insert anchors before them, e.g. there is included a Fusion processor to help with that:

```
prototype(Neos.Neos:Content).@process.anchor = DIU.Neos.AnchorLink:AnchorWrapper
```

## Configuration

It's possible to configure the content node nodetype that is used for linking. Also it's possible to use a different property for the anchor value and the label via Settings.yaml.

These are the defaults:

```yaml
DIU:
  Neos:
    AnchorLink:
      contentNodeType: "DIU.Neos.AnchorLink:AnchorMixin"
      anchor: ${node.properties.anchor || node.name}
      label: ${node.label}
```

It's possible to disable the searchbox or adjust its threshold via Settings.yaml, the default settings are:

```yaml
Neos:
  Neos:
    Ui:
      frontendConfiguration:
        "Diu.Neos.AnchorLink":
          displaySearchBox: true
          threshold: 0
```

## Low-level Customization

Finally it is possible to create a completely custom anchor nodes resolver.

Create a class implementing `AnchorLinkResolverInterface` that would take current content node, link and a searchTerm and return an array of options for the link anchor selector and configure it in `Objects.yaml` like this:

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
