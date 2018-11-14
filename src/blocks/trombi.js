const { createElement } = wp.element
const { registerBlockType } = wp.blocks
const { ServerSideRender } = wp.components

registerBlockType("bergson/trombi", {
    title: "Trombi",
    description: "Affichage d‘un trombinoscope",
    icon: "images-alt",
    category: "common",

    edit: function() {
        return ( <ServerSideRender
            block="bergson/trombi"
            //attributes={ props.attributes }
        /> )
    },

    save: function() {
        return null
    }
})