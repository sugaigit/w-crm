$(document).ready(function() {
  let showFilter = $('select[name="show_filter"]');

  showFilter.change(function() {
    window.location.href = 'customers?show_filter=' + $(this).val();
  });

});
