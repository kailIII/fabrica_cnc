var parentPage="";
function itemObject(a,b){this.json=a;
this.index=b;
this.fullPath=function(){return this.json.fullPath
};
this.name=function(){return this.json.displayName
};
this.date=function(){try{return new Date(this.json.lastmodified).f(_data.dateFormat)
}catch(c){return new Date()
}};
this.size=function(){var c=this.json.size;
var e=["Bytes","KB","MB","GB","TB"];
if(c==0){return"n/a"
}var d=parseInt(Math.floor(Math.log(c)/Math.log(1024)));
return Math.round(c/Math.pow(1024,d),2)+" "+e[d]
};
this.id=function(){if(this.isDir()){return"folder_"+this.index
}return"file_"+this.index
};
this.href=function(){return _data.webdavUrl+this.fullPath()
};
this.isDir=function(){return this.json.type=="Collection"
};
this.getObject=function(){return{fullPath:this.fullPath(),name:this.name(),date:this.date(),size:this.size(),id:this.id(),href:this.href(),isDir:this.isDir()}
}
}(function(a){a.nano=function(b,c){return b.replace(/\{([\w\.]*)\}/g,function(g,d){var e=d.split("."),f=c[e.shift()];
a.each(e,function(){f=f[this]
});
return(f===null||f===undefined)?"":f
})
}
})(jQuery);
$(document).ready(function(){if(_data.webdavUrl==""||_data.webdavUrl==null){_data.webdavUrl=document.location.href.substring(0,document.location.href.lastIndexOf("/"))
}if(_data.webdavUrlPrefix!=""&&_data.webdavUrlPrefix!=null){_data.webdavUrl+="/"+_data.webdavUrlPrefix
}if(_data.applicationType=="php"){$("#aspNetMessage").hide();
$("#phpMessage").show()
}else{$("#aspNetMessage").show();
$("#phpMessage").hide()
}getFilesList(_data.currentDirectory,"get");
$("a[id^='folder']").live("click",clickOnItem)
});
function refreshCurrentDir(){var a="";
if(_data.pageInfo){if(_data.pageInfo.symbol&&_data.pageInfo.symbol!=""){a=_data.pageInfo.symbol
}else{if(_data.pageInfo.page){a=_data.pageInfo.page
}}}getFilesList(_data.currentDirectory,"get",a)
}function goToPage(a){getFilesList(_data.currentDirectory,"get",a)
}function getFilesList(a,c,b){b=b||"";
if(c==null||c==undefined||c=="get"){_data.currentDirectory=a
}$.blockUI.defaults.fadeIn=200;
$.blockUI.defaults.fadeOut=0;
$("#filesList").block({message:$("#waitMessage"),fadeIn:200,fadeOut:0});
$.ajax({url:_data.serverUrl,data:{command:c,path:a,isAjax:"true",page:b},dataType:"json",cache:false,success:filesListReceived,error:function(e,d){alert("Error : "+d)
},complete:function(){$("#filesList").unblock()
}})
}function filesListReceived(a,b){$("#currentWebPath").val(_data.webdavUrl+_data.currentDirectory);
_data.files=new Array();
if(a.error!=null&&a.error.length>0){alert(a.error)
}if(a.files!=null){$.each(a.files,function(c,d){_data.files[c]=new itemObject(d,c)
})
}if(a.pageInfo){_data.pageInfo=a.pageInfo
}renderFilesList();
renderPageNavigator()
}function renderFilesList(){if(_data.files!=null){var a=null;
$("#tableFilesList").empty();
$("#tableFilesList").prepend($("#tableRowHeader").html());
$("#tableFilesList").append("<tbody class='fileList_table'></tbody");
a=$("#tableFilesList").find("tbody");
if(_data.currentDirectory!="/"){addFileRow(getParentDirectoryItem(),a)
}$.each(_data.files,function(b,c){addFileRow(c,a)
});
$("a[id^='file']").contextMenu(_data.contextMenuItems,{showOn:"both",beforeShow:beforeShowContextMenu});
$("a[id^='folder']").contextMenu(_data.contextMenuItems,{showOn:"right",beforeShow:beforeShowContextMenu})
}$("#currentDirecory").text(_data.currentDirectory)
}function renderPageNavigator(){var B=null,y=null;
$("#pageNavigator_top").empty();
$("#pageNavigator_bottom").empty();
$("#boxPageInfo").empty();
if(_data.pageInfo&&_data.pageInfo.totalPages&&_data.pageInfo.page&&_data.pageInfo.totalPages>1){var x=_data.pageInfo.totalPages,A=_data.pageInfo.page,H=$("#pageItem").html(),m=_data.pageInfo.symbol,G=_data.pageInfo.chars,z=0;
var w=m&&m!=""&&G&&(z=G.length)>0;
if(w){x=z
}var t=function(c){return w?'"'+(G.charAt(c-1))+'"':c
},j=function(c){return w?G.charAt(c-1):c
};
var h=$.nano(H,{style:"",page:t(1),text:"&lt;&lt;"}),r=$.nano(H,{style:"",page:t(A==1?x:(A-1)),text:"&lt;"}),g=$.nano(H,{style:"",page:t(A==x?1:(A+1)),text:"&gt;"}),d=$.nano(H,{style:"",page:t(x),text:"&gt;&gt;"}),F,D,o,k,E,f;
$("#pageNavigator_top").append("<tbody class='pageNavigator_table'><tr></tr></tbody");
$("#pageNavigator_bottom").append("<tbody class='pageNavigator_table'><tr></tr></tbody");
B=$("#pageNavigator_top").find("tr");
y=$("#pageNavigator_bottom").find("tr");
B.append(r);
y.append(r);
if(x<10){for(var u=1;
u<=x;
u++){o=$.nano(H,{style:(A==u?"_selected":""),page:t(u),text:j(u)});
B.append(o);
y.append(o)
}}else{F=$.nano(H,{style:(1==A?"_selected":""),page:t(1),text:j(1)});
B.append(F);
y.append(F);
var C=2;
if(A>4){k=$.nano(H,{style:"",page:t(A-3),text:"..."});
B.append(k);
y.append(k);
for(var a=A-2;
a<=A+2&&a<=x;
a++){o=$.nano(H,{style:(A==a?"_selected":""),page:t(a),text:j(a)});
B.append(o);
y.append(o);
C=a
}}else{for(var b=2;
b<=A+2&&b<=x;
b++){o=$.nano(H,{style:(A==b?"_selected":""),page:t(b),text:j(b)});
B.append(o);
y.append(o);
C=b
}}if(x-C>1){k=$.nano(H,{style:"",page:t(A+3),text:"..."});
B.append(k);
y.append(k)
}if(x-C>0){f=$.nano(H,{style:(x==A?"_selected":""),page:t(x),text:j(x)});
B.append(f);
y.append(f)
}}B.append(g);
y.append(g);
if((w||_data.pageInfo.pageSize)&&_data.pageInfo.total&&_data.pageInfo.totalOnPage){var e;
$("#boxPageInfo").append($.nano($("#pageInfo").html(),{items:w?_data.pageInfo.totalOnPage:String((e=(A-1)*_data.pageInfo.pageSize+1))+"&nbsp;-&nbsp;"+String(e+_data.pageInfo.totalOnPage-1),total:_data.pageInfo.total}))
}}}function addFileRow(a,b){var c="#tableRowFile";
if(a.isDir()){c="#tableRowFolder"
}b.append($.nano($(c).html(),a.getObject()))
}function getParentDirectoryItem(){return new itemObject({type:"Collection",fullPath:getParentPath(_data.currentDirectory),displayName:".."},"parent")
}function getParentPath(b){var a=b;
if(b.lastIndexOf("/")>=0){b=b.substring(0,b.lastIndexOf("/"))
}if(b.indexOf("/")<0){return"/"+b
}return b
}function getIndexByElement(a){var c=a.id;
try{return c.indexOf("file_")>=0?c.substring(c.indexOf("file_")+"file_".length):c.indexOf("folder_")>=0?c.substring(c.indexOf("folder_")+"folder_".length):-1
}catch(b){}return -1
}function getItemByIndex(a){if(a=="parent"){return getParentDirectoryItem()
}if(a>=0&&a<_data.files.length){return _data.files[a]
}return null
}function getItemByElement(a){return getItemByIndex(getIndexByElement(a))
}function clickOnItem(){var a=getItemByElement(this);
if(a!=null){if(a.isDir()){if(a.index==="parent"){getFilesList(a.fullPath(),"get",parentPage)
}else{parentPage="";
if(_data.pageInfo){if(_data.pageInfo.symbol&&_data.pageInfo.symbol!=""){parentPage=_data.pageInfo.symbol
}else{if(_data.pageInfo.page){parentPage=_data.pageInfo.page
}}}getFilesList(a.fullPath(),"get")
}}}else{alert("File not found!")
}return false
}function beforeShowContextMenu(){var c=getItemByElement(this.target),d=null;
if(c!=null){if(c.isDir()){d=getMenuItem($(this.menu),"download");
if(d!=null){$(d).addClass("context-menu-item-disabled")
}if(c.index=="parent"){d=getMenuItem($(this.menu),"delete");
if(d!=null){$(d).toggleClass("context-menu-item-disabled")
}}}else{var b=OfficeOpen.GetMSOSupportedTypes().indexOf(";"+OfficeOpen.GetFileExtension(c.name().toLowerCase())+";")!=-1;
var a=OfficeOpen.oooSupportedtypes.indexOf(";"+OfficeOpen.GetFileExtension(c.name().toLowerCase())+";")!=-1;
d=getMenuItem($(this.menu),"open");
if(d!=null){$(d).removeClass("context-menu-item-disabled");
if(!b&&!a){$(d).addClass("context-menu-item-disabled")
}}d=getMenuItem($(this.menu),"openms");
if(d!=null){$(d).removeClass("context-menu-item-disabled");
if(!b){$(d).addClass("context-menu-item-disabled")
}}d=getMenuItem($(this.menu),"openoo");
if(d!=null){$(d).removeClass("context-menu-item-disabled");
if(!a){$(d).toggleClass("context-menu-item-disabled")
}}}}}function getMenuItem(b,a){return b.find("#"+a).get(0)
}function downloadFile(a){document.location=_data.webdavUrl+a.fullPath()
}function deleteFile(a){if(confirm("Are you sure you want to delete '"+a.name()+"'?")){getFilesList(a.fullPath(),"delete")
}}function cancelBrowseDialog(){$("#filesList").unblock()
}function showBrowseDialog(a){var b=$("#OfficeLauncher").get(0);
if(_data.fileToOpen!=null){b.openDocument(_data.webdavUrl+_data.fileToOpen.fullPath(),4,OfficeOpen.GetAssosiatedMSApp(a));
if(b.getDetectedOfficeType()>0){_data.fileToOpen=null;
cancelBrowseDialog()
}}}function _openFile(c,d){var a=null;
if(typeof c=="string"){a=new itemObject({fullPath:"/"+c,type:"File",displayName:c},-1)
}else{a=c
}if(!a.isDir()){var b=_data.webdavUrl+a.fullPath();
_data.fileToOpen=a;
OfficeOpen.OpenFileWith(b,d)
}else{getFilesList(a.fullPath(),"get")
}}function openFile(a){_openFile(a,_data.modeToOpen)
}function openFileMO(a){_data.modeToOpen=0;
_openFile(a,_data.modeToOpen)
}function openFileMS(a){_data.modeToOpen=2;
_openFile(a,_data.modeToOpen)
}function openFileOO(a){_data.modeToOpen=3;
_openFile(a,_data.modeToOpen)
}function openFileWith(a,b){_data.modeToOpen=b;
_openFile(a,b)
}OfficeOpen.LauncherInited=function(a){};
OfficeOpen.BeforeOfficeLaunch=function(a){_data.pathDetected=true;
if(_data.fileToOpen==null){return false
}};
OfficeOpen.AfterOfficeLaunch=function(a){_data.fileToOpen=null
};
OfficeOpen.OfficePathNotDetected=function(){_data.pathDetected=false;
$("#filesList").block({message:$("#selectProgrammToOpen"),fadeIn:200,fadeOut:200})
};