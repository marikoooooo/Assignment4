const {
  updateCategory
} = wp.blocks;

const WpEasyCartIcon = () =>  wp.element.createElement( wp.components.Icon, {
  icon: () =>  wp.element.createElement( "svg", {
        width: "25",
        height: "25",
        viewBox: "0 0 25 25"
    }, wp.element.createElement( "image", {
        xlinkHref: "data:img/png;base64,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"
      }))
});

(function () {
	updateCategory( 'wp-easycart', { 
        icon: WpEasyCartIcon
	});
})();