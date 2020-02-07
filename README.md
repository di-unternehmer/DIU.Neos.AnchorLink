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
Neos.Neos:Content: # Or other nodetype
  superTypes:
    DIU.Neos.AnchorLink:AnchorMixin: true
```

4. Adjust the rendering for those nodes to insert anchors before them, e.g. there is included a Fusion processor to help with that:

```
prototype(Neos.Neos:Content).@process.anchor = DIU.Neos.AnchorLink:AnchorLinkAugmentor
```

Note: this will add an `id` attribute to the corresponding output. For this to work reliably the corresponding prototype should render
a single root element. Otherwise an additional wrapping `div` element will be rendered.
Also the rendered content must not already contain an `id` attribute because it would be merged with the one from the augmentor in that case.

## Configuration

It's possible to configure the content node nodetype that is used for linking. Also it's possible to use a different property for the anchor value and the label via Settings.yaml.

These are the defaults:

```yaml
DIU:
  Neos:
    AnchorLink:
      # Only nodes of this type will appear in the "Choose link anchor" selector
      contentNodeType: "DIU.Neos.AnchorLink:AnchorMixin"
      # Eel Expression that returns the anchor (without leading "#") for a given node
      anchor: ${node.properties.anchor || node.name}
      # Eel Expression that returns the label to be rendered in the anchor selector in the Backend
      label: ${node.label}
      # Eel Expression that returns a group for the anchor selector (empty string == no grouping)
      group: ${I18n.translate(node.nodeType.label)}
      # Eel Expression that returns an icon for the anchor selector (empty string = no icon)
      icon: ${node.nodeType.fullConfiguration.ui.icon}
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
