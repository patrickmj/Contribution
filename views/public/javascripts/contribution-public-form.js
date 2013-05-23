
function enableContributionTypeButtons(url) {
    var typeButtons = jQuery('a.type-option');
    var typeFormDiv = jQuery('div#type-form');
    
    typeButtons.click(function(e) {
        e.preventDefault();
        var el = jQuery(this);
        var typeId = el.attr('value');
        typeFormDiv.empty();
        jQuery.post(url, {contribution_type: typeId}, function(data) {
            typeFormDiv.append(data);
        });
    });
}
