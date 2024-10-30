document.addEventListener("DOMContentLoaded", loadMeeteoScript);
function loadMeeteoScript() {
        let meta = document.getElementsByTagName("META");
        let companyDomain = "";
        let appid = "";
        for (let i = 0; i < meta.length; i++) {
                if(meta[i].name=="meeteo-company-domain"){
                        companyDomain = meta[i].content
                }
                if(meta[i].name=="meeteo-appid"){
                        appid = meta[i].content
                }
        }
        console.log(companyDomain)
        widget = document.createElement("script");
        text = document.createTextNode(`Meeteo.initPopupWidget({url: "${companyDomain}",appId: "${appid}"});`);
        widget.setAttribute('type', 'text/javascript');
        widget.appendChild(text);
        document.querySelector('body').appendChild(widget);
}