# DIU.Neos.AnchorLink

Extends the Neos CKE5 linkeditor with server-side resolvable anchor links.

Enable additional linking options with such config:

```
"Neos.NodeTypes.BaseMixins:TextMixin":
  properties:
    text:
      ui:
        inline:
          editorOptions:
            linking:
              anchorLink: true
```

## Development

If you need to adjust anything in this package, just do so and then rebuild the code like this:

```
cd Resources/Private/AnchorLink
yarn && yarn build
```

And then commit changed filed including Plugin.js

# TODO:

- i18n labels
- link resolver interface
- componentDidUpdate
- readme
- cache
