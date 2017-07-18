<script src="/theme/onzsa/assets/global/scripts/metronic.js"></script>
<script src="/theme/onzsa/assets/admin/pages/scripts/index.js"></script>

<script>
function commonInit() {
  Metronic.init(); // Run metronic theme
  Index.init();

  window.onpopstate = function (event) {
    console.log("location: " + location.pathname + ", state: " + JSON.stringify(event));
    if (location.pathname == '/sell/') {
    }
  }
  history.pushState(location.origin, location.hash, location.pathname);
}
</script>
