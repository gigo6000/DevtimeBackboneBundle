window.app = {
  Models: {},
  Collections: {},
  Views: {},
  Routers: {},
  init: function() {
    alert('Hello from Backbone!');
  }
};

$(document).ready(function(){
  app.init();
});
