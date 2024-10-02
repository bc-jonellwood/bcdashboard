function createDeleteConfirmationPopover(id) {
  var html = `
  
    <div class="popover-header">
    <h3>Delete Confirmation</h3>
    <button type="button" class="btn-x" popovertarget="deleteConfirmationPopover" popovertargetaction="hide"
    aria-label="Close">X
    </button>
    </div>
    <div class="popover-body">
    <p>Are you sure you want to delete this time slot?</p>
    </div>
    <div class="popover-footer">
    <button type="button" class="btn btn-danger" onclick="deleteSession('${id}')" popovertarget="deleteConfirmationPopover" popovertargetaction="hide">Delete</button>
    <button type="button" class="btn btn-secondary" popovertarget="deleteConfirmationPopover" popovertargetaction="hide" 
    aria-label="Close">Cancel</button>
    </div>
    
`;
  document.getElementById("deleteConfirmationPopover").innerHTML = html;
}
