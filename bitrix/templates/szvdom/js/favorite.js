function getBrowserInfo() {
 var t="",v = "";
 if (navigator.userAgent.indexOf('Chrome')>=0) t='Chrome';
 else if (window.opera) t = 'Opera';
 else if (document.all) {
  t = 'IE';
  var nv = navigator.appVersion;
  var s = nv.indexOf('MSIE')+5;
  v = nv.substring(s,s+1);
 }
 else if (navigator.appName) t = 'Netscape';
 return { type:t, version:v };
}
 
function bookmark(a){
 var url = window.document.location;
 var title = window.document.title;
 var b = getBrowserInfo();
 if (b.type == 'Chrome') {
  alert("К сожалению, в Google Chrome нет метода для программного добавления в Закладки... нажмите CTRL+D");
 }
 else if (b.type == 'IE' && b.version >= 4) {
  window.external.AddFavorite(url,title);
 }
 else if (b.type == 'Opera') {
  a.href = url;
  a.rel = "sidebar";
  a.title = url+','+title;
  return true;
 }
 else if (b.type == 'Netscape') {
  window.sidebar.addPanel(title,url,"");
 }
 else alert("Не могу определить браузер... нажмите CTRL+D для добавления страницы в Избранное");
 return false;
}