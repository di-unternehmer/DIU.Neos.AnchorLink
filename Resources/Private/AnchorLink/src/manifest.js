import manifest from "@neos-project/neos-ui-extensibility";
import LinkEditorOptions from "./LinkEditorOptions";

manifest("DIU.Neos.AnchorLink", {}, globalRegistry => {
  const containerRegistry = globalRegistry.get("containers");

  containerRegistry.set(
    "LinkInput/OptionsPanel/AnchorLinkOptions",
    LinkEditorOptions
  );
});
