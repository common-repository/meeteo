document.addEventListener("DOMContentLoaded", function () {
  // Datatable Init
  if (
    document.querySelector(".meeteo-card").querySelector("#datatable") !== null
  ) {
    const dataTable = new simpleDatatables.DataTable("#datatable", {
      searchable: true,
      fixedHeight: false,
      layout: {
        top: "{search}",
        bottom: "{select}{pager}{info}",
      },
    });
  }

  // Slim Select Init
  if ( document.querySelector(".meeteo-card").querySelector('select') !== null) {
    new SlimSelect({
      select: "select",
      showSearch: false,
    });
  }

  // Vanilla Tab Init
  new VanillaTabs({
    selector: ".default-tab", // default is ".tabs"
    type: "horizontal", // can be horizontal / vertical / accordion
    responsiveBreak: 840, // tabs become accordion on this device width
    activeIndex: 0, // active tab index (starts from 0 ). Can be -1 for accordions.
  });
});
