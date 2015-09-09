<script>
function commonInit() {
  Metronic.init(); // Run metronic theme
  Index.init();
  Metronic.setAssetsPath('/theme/metronic/assets/'); // Set the assets folder path

  window.onpopstate = function (event) {
    console.log("location: " + location.pathname + ", state: " + JSON.stringify(event));
    if (location.pathname == '/sell/') {
    }
  }
  history.pushState(location.origin, location.hash, location.pathname);
}
</script>