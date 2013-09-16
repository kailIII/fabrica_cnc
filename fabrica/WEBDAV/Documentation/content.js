var prevHash = null;

if ("onhashchange" in window) // event supported?
{
    window.onhashchange = function ()
    {
        hashChanged(window.location.hash);
    }
}
else // event not supported:
{
    var storedHash = window.location.hash;
    window.setInterval(function ()
    {
        if (window.location.hash != storedHash)
        {
            storedHash = window.location.hash;
            hashChanged(storedHash);
        }
    }, 100);
}


function hashChanged(newHash)
{	
	if(prevHash != null && document.getElementById(prevHash) != null)
		document.getElementById(prevHash).className = "";
		
	if(newHash != null)
	{
		var hash = newHash.substring(1);
		var element = document.getElementById(hash);
		if(element != null)
			element.className = "highlightAnchor";
	}
	/*else
		alert('not found'+hash);
		*/
	prevHash = hash;
}

function buildZebraTable(tableId)
{

	var table=document.getElementById(tableId);
	
	if(!table){return};
	
	var evenFlag=false;
	
	var rows=table.getElementsByTagName('tr');
	
	for(var i=0;i<rows.length;i++){
	
	rows[i].className=!evenFlag?'oddrow':'evenrow';
	
	evenFlag=!evenFlag;
	
	}

}

