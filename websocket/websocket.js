try {
    /*
            PHBPlugin Websocket client v2.0
                  By PHB - Pedro HB
                Discord: PedroHB#9569
            https://discord.gg/GZY3EQ3hEH
    */

    /* Global Variables */
    var PHBSettings = {};
    var UserMenu;
    var myAccount = {};

    /* Websocket Connection */
    function connectPHBSockets() {
        websocket = new WebSocket(PHBSettings.websocket_url);
        websocket.onopen = function (evt) { AuthenticatorCommand(); };
        websocket.onclose = function (evt) { onClose(evt) };
        websocket.onmessage = function (evt) { onMessage(evt) };
        websocket.onerror = function (evt) { onError(evt) };
    }

    function onError(evt) {
        log(`[${PHBSettings.texts.debug.types.error}] ${JSON.stringify(evt)}`);
    }

    function onClose(evt) {
        log(`[${PHBSettings.texts.debug.types.info}] ${PHBSettings.texts.debug.disconnected}`);
        setTimeout(function () { connectPHBSockets(); }, 5000);
    }

    function sendMessage(message) {
        if (websocket.readyState != WebSocket.OPEN) return;
        log(`[${PHBSettings.texts.debug.types.outgoing}] ${JSON.stringify(message)}`);
        websocket.send(JSON.stringify(message));
    }

    function log(message) {
        //console.log(message);
    }

    /* Websocket Command Handler */
    function onMessage(evt) {
        log(`[${PHBSettings.texts.debug.types.incoming}] ${evt.data}`);
        const evtParsed = JSON.parse(evt.data);
        switch (evtParsed.header) {
            case "ping":
                PongCommand();
                break;
            case "mention":
                MentionCommand(evtParsed.data);
                break;
            case "event_alert":
                EventAlertCommand(evtParsed.data);
                break;
            case "video_phb":
                VideoCommand(evtParsed.data);
                break;
            case "helloworld":
                HelloWorldCommand(evtParsed.data);
                break;
            case "userclick":
                UserInteractionCommand(evtParsed.data);
                break;
            case "image":
                ImageCommand(evtParsed.data);
                break;
            case "entryroom":
                SetRoomCommand(evtParsed.data);
                CloseUserInteractionCommand();
                break;
            case "exit_room":
                CloseUserInteractionCommand();
                break;
            case "youtube_tv":
                OpenYoutubeTvCommand(evtParsed.data);
                break;
            case "catalog":
                OpenPaymentCommand(evtParsed.data);
                break;
            case "youtube_music":
                OpenYoutubeMusic(evtParsed.data);
                break;
            case "edit_item":
                OpenEditItemCommand(evtParsed.data);
                break;
            default:
                console.log(`[${PHBSettings.texts.debug.types.error}] Unhandled incoming => ${evt.data}`);
                break;
        }
    }

    /* Create HTML Elements */
    function createHtmlElements() {
        phbPlugin = document.createElement("div");
        phbPlugin.id = "PHBPlugin";
        phbPlugin.style.zIndex = 9999;
        /* RoomInfo Element */
        roomName = document.createElement("p");
        roomName.id = "roomName";
        roomId = document.createElement("p");
        roomId.id = "roomId";
        roomDiv = document.createElement("div");
        roomDiv.id = "roomInfo";
        roomDiv.style.display = "none";
        roomDiv.appendChild(roomName);
        roomDiv.appendChild(roomId);
        phbPlugin.appendChild(roomDiv);
        /* Edit Items Div */
        divEditItem = document.createElement("div");
        divEditItem.id = "PHBPlugin-editItem";
        phbPlugin.appendChild(divEditItem);
        /* Youtube Player Div */
        divYoutubePlayer = document.createElement("div");
        divYoutubePlayer.id = "PHBPlugin-YoutubePlayer";
        phbPlugin.appendChild(divYoutubePlayer);
        /* Youtube TV Div */
        divYoutubeTV = document.createElement("div");
        divYoutubeTV.id = "PHBPlugin-YoutubeTV";
        phbPlugin.appendChild(divYoutubeTV);
        /* Twitch Player Div */
        divTwitchPlayer = document.createElement("div");
        divTwitchPlayer.id = "PHBPlugin-TwitchPlayer";
        phbPlugin.appendChild(divTwitchPlayer);
        /* Image Container Div */
        divImageContainer = document.createElement("div");
        divImageContainer.id = "PHBPlugin-ImageContainer";
        phbPlugin.appendChild(divImageContainer);
        /* PH Player Div */
        divPHPlayer = document.createElement("div");
        divPHPlayer.id = "PHBPlugin-PHPlayer";
        phbPlugin.appendChild(divPHPlayer);
        /* XV Player Div */
        divXvPlayer = document.createElement("div");
        divXvPlayer.id = "PHBPlugin-XvPlayer";
        phbPlugin.appendChild(divXvPlayer);
        /* Spotify Player Div */
        divSpotifyPlayer = document.createElement("div");
        divSpotifyPlayer.id = "PHBPlugin-SpotifyPlayer";
        phbPlugin.appendChild(divSpotifyPlayer);
        /* Facebook Player Div */
        divFacebookPlayer = document.createElement("div");
        divFacebookPlayer.id = "PHBPlugin-FacebookPlayer";
        phbPlugin.appendChild(divFacebookPlayer);
        /* Notification Container Div */
        divNotification = document.createElement("div");
        divNotification.id = "PHBPlugin-Notifications";
        divNotification.style.display = "block";
        divNotification.style.top = "115px";
        divNotification.style.zIndex = "99999px";
        phbPlugin.appendChild(divNotification);
        /* EventAlert Container Div */
        divEventAlert = document.createElement("div");
        divEventAlert.id = "PHBPlugin-EventAlert";
        phbPlugin.appendChild(divEventAlert);
        /* Payment Container Div */
        divPayment = document.createElement("div");
        divPayment.id = "PHBPlugin-PaymentContainer";
        phbPlugin.appendChild(divPayment);

        UserMenu = document.createElement("div");
        UserMenu.style.fontFamily = "normal";
        UserMenu.style.display = "";
        UserMenu.style.color = "black";
        UserMenu.id = "PHBPluginUserInteractionMenu";
        phbPlugin.appendChild(UserMenu);

        /* Append to Page */
        document.body.appendChild(phbPlugin);
    }

    window.addEventListener("load", function () {
        /* CSS And JS */
        jQueryAppend = document.createElement("script");
        jQueryAppend.src = "https://code.jquery.com/jquery-1.12.4.js";
        jQueryAppend.type = "text/javascript";
        document.head.appendChild(jQueryAppend);
        jQueryUiAppend = document.createElement("script");
        jQueryUiAppend.src = "https://code.jquery.com/ui/1.12.1/jquery-ui.js";
        jQueryUiAppend.type = "text/javascript";
        document.head.appendChild(jQueryUiAppend);
        pluginStyle = document.createElement("link");
        pluginStyle.href = "https://ws.vicehabbo.fr/box.css";
        pluginStyle.rel = "stylesheet";
        pluginStyle.type = "text/css";
        document.head.appendChild(pluginStyle);
        console.log("%cPHBPlugin Edited for ViceHabbo%c\n\nThanks⠀to⠀use⠀PHBPlugin.\nTo⠀buy⠀this⠀plugin⠀access⠀phb.services⠀or⠀discord.gg/GZY3EQ3hEH\n\n", "color: #7289DA; -webkit-text-stroke: 2px black; font-size: 72px; font-weight: bold;", "");

        setTimeout(function () {
            $.ajax({ url: PHBPluginConfig.configurationUrl, async: false, dataType: 'json', success: function (data) { PHBSettings = data; console.log(data); } });
            connectPHBSockets();
            createHtmlElements();
        }, 3500);
    }, false);

    /* Commands */
    function KissUserCommand(username) {
        sendMessage({ header: "user_kiss", data: { "username": username } });
    }

    function SlimeUserCommand(username) {
        sendMessage({ header: "user_slime", data: { "username": username } });
    }

    function PullUserCommand(username) {
        sendMessage({ header: "user_pull", data: { "username": username } });
    }

    function PushUserCommand(username) {
        sendMessage({ header: "user_push", data: { "username": username } });
    }

    function HugUserCommand(username) {
        sendMessage({ header: "user_hug", data: { "username": username } });
    }

    function BombUserCommand(username) {
        sendMessage({ header: "user_bomb", data: { "username": username } });
    }

    function SexUserCommand(username) {
        sendMessage({ header: "user_sex", data: { "username": username } });
    }
	
	function EnableCommand(){
		sendMessage({ header: "staff_effect", data: { } });
	}

    function AuthenticatorCommand() {
        log(`[${PHBSettings.texts.debug.types.info}] ${PHBSettings.texts.debug.connected}`);
        sendMessage({ header: "sso", data: { "ticket": PHBPluginConfig.sso } });
    }

    function PongCommand() {
        sendMessage({ header: "pong", data: { message: "" } });
    }

    function HelloWorldCommand(data) {
        myAccount = data;
    }

        function EventAlertCommand(data) {
        document.getElementById("PHBPlugin-EventAlert").innerHTML = "";

        EventAlert = document.createElement("div");
        EventAlert.id = "acontour";
        AlerteBody = document.createElement("div");
        AlerteBody.id = 'acontent';
        Hotel15 = document.createElement("div");
        Hotel15.classList.add("aleft");
        ImageAvatara = document.createElement("img");
        ImageAvatara.src = String(PHBSettings.functions.eventalert.image);
        Hotel15.appendChild(ImageAvatara);
        AlerteBody.appendChild(Hotel15);


        Hotel1456 = document.createElement("div");
        Hotel1456.classList.add("aright");
        ImageAvataraa = document.createElement("img");
        ImageAvataraa.src = String(PHBSettings.functions.eventalert.little);
        Hotel1456.appendChild(ImageAvataraa);
        AlerteBody.appendChild(Hotel1456);

        Hotel17 = document.createElement("div");
        Hotel17.classList.add("atitle");
        Hotel17.innerText = "Message des Staffs"
        Hotel1499 = document.createElement("hr");
        Hotel1456.appendChild(Hotel17);
        Hotel1456.appendChild(Hotel1499);
        AlerteBody.appendChild(Hotel1456);

        now = new Date();
        heure   = now.getHours();
        minute  = now.getMinutes();
        Hotel1452 = document.createElement("div");
        Hotel1452.classList.add("atext");
        Hotel1896 = document.createElement("p");
        Hotel1896.innerText = "Il est "+heure+"h"+minute+" et c'est l'heure d'une nouvelle animation sur Habbo";
        Hotel1823 = document.createElement("p");
        Hotel1823.classList.add("intitle");
        Hotel1823.innerHTML = `Rejoins-moi chez <b> ${data.username} </b> pour un nouveau jeu qui s'intitle <b> :: ${data.room_name} :: </b>`;
        Hotel1843 = document.createElement("p");
        Hotel1843.innerText = "Rends toi vite dans l'appart afin de remporter un mobilier exclusif ainsi qu'un badge.";


        Hotel1456.appendChild(Hotel1452);

        Hotel1452.appendChild(Hotel1896);
        Hotel1452.appendChild(Hotel1823);
        Hotel1452.appendChild(Hotel1843);
        AlerteBody.appendChild(Hotel1456);


        Hotel1418 = document.createElement("div");
        Hotel1418.classList.add("afooterstaff");
        Hotel1296 = document.createElement("span");
        Hotel1296.innerText = data.username;

        Hotel1456.appendChild(Hotel1418);
        Hotel1418.appendChild(Hotel1296);
        

        ImageAvatar = document.createElement("img");
        ImageAvatar.src = String(PHBSettings.functions.eventalert.avatar_image).replace("%figure%", data.userlook);
        Hotel1296.appendChild(ImageAvatar);
        AlerteBody.appendChild(Hotel1456);

        Hotel23 = document.createElement("div");
        Hotel23.id = "hotel23";
        CloseAlert = document.createElement("div");
        CloseAlert.onclick = function () {
            document.getElementById("acontour").style.display = "none";
        };
        CloseAlert.id = "hotel24";
        CloseAlert.innerText = String(PHBSettings.texts.eventalert.close);
        Hotel23.appendChild(CloseAlert);

        GoButton = document.createElement("div");
        GoButton.onclick = function () {
            GoToRoomCommand(data.room_id);
            var n = $(".acontour");
            n.animate({ left: "-700px" }), setTimeout(function () { n.fadeOut(500).remove() }, 1500);
        };
        GoButton.id = "hotel25";
        GoButton.innerText = String(PHBSettings.texts.eventalert.go);
        Hotel23.appendChild(GoButton);
        Hotel23.appendChild(CloseAlert);
        
        Hotel1418.appendChild(Hotel23);
        AlerteBody.appendChild(Hotel1456);

        Div = document.createElement("div");
        AlerteBody.appendChild(Div);
        EventAlert.appendChild(AlerteBody);

        document.getElementById("PHBPlugin-EventAlert").appendChild(EventAlert);

        $(".acontour").fadeIn(500);
        $(".acontent").animate({ "margin-left": "-295px" }, 500);

        setTimeout(function () {
            var n = $(".acontour");
            n.animate({ left: "-700px" }), setTimeout(function () { n.fadeOut(500).remove() }, 1500);
        }, 10000);
    }

    function GoToRoomCommand(id) {
        sendMessage({ header: "go_room", data: { "roomid": id } });
    }

    function VideoCommand(data) {
        switch (data.type) {
            case "youtube":
                OpenYoutubeVideoCommand(data);
                break;
            case "twitch":
                OpenTwitchVideoCommand(data);
                break;
            case "xvideos":
                OpenXvideosVideoCommand(data);
                break;
            case "pornhub":
                OpenPornhubVideoCommand(data);
                break;
            case "facebook":
                OpenFacebookVideoCommand(data);
                break;
            default:
                console.log(`Video provider not found: ${data.type}`);
                break;
        }
    }

    function OpenYoutubeVideoCommand(data) {
        document.getElementById("PHBPlugin-YoutubePlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBYTContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-YoutubePlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 640;
        IframeTag.height = 360;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://www.youtube.com/embed/${data.id}?autoplay=1&origin=${location.hostname}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-YoutubePlayer").appendChild(VideoContainer);
        $("#PHBYTContainer").draggable({ containment: "window" });
    }

    function OpenTwitchVideoCommand(data) {
        document.getElementById("PHBPlugin-TwitchPlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBTWContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-TwitchPlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 640;
        IframeTag.height = 360;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://player.twitch.tv/?channel=${data.id}&parent=${location.hostname}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-TwitchPlayer").appendChild(VideoContainer);
        $("#PHBTWContainer").draggable({ containment: "window" });
    }

  /*  function OpenXvideosVideoCommand(data) {
        document.getElementById("PHBPlugin-XvPlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBXVContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-XvPlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 640;
        IframeTag.height = 360;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://www.xvideos.com/embedframe/${data.id}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-XvPlayer").appendChild(VideoContainer);
        $("#PHBXVContainer").draggable({ containment: "window" });
    } */

   /* function OpenPornhubVideoCommand(data) {
        document.getElementById("PHBPlugin-PHPlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBPHContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-PHPlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 640;
        IframeTag.height = 360;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://www.pornhub.com/embed/${data.id}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-PHPlayer").appendChild(VideoContainer);
        $("#PHBPHContainer").draggable({ containment: "window" });
    }*/

    function OpenFacebookVideoCommand(data) {
        document.getElementById("PHBPlugin-FacebookPlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBFBContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-FacebookPlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 640;
        IframeTag.height = 360;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://www.facebook.com/plugins/video.php?href=${data.id}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-FacebookPlayer").appendChild(VideoContainer);
        $("#PHBFBContainer").draggable({ containment: "window" });
    }

    function UserInteractionCommand(data) {
        if (!PHBSettings.functions.interaction_user_menu) return;
        if (data.me) return;

        isOpenButtons = true;

        ButtonsPHB = document.createElement("div");
        ButtonsPHB.classList.add("buttons");
        ButtonsPHB.id = "buttonsPHB";
        UserMenu.appendChild(ButtonsPHB);

        Close = document.createElement("div");
        Close.id = "close";
        CloseButton = document.createElement("div");
        CloseButton.id = "close-button";
        CloseButton.style.transform = "scaleX(-1)";
        CloseButton.addEventListener('click', function (event) {
            if (!isOpenButtons) {
                isOpenButtons = true;
                document.querySelector('.buttons').style.width = "50px";
                document.getElementById('close-button').style.transform = "scaleX(-1)";
            } else {
                isOpenButtons = false;
                document.querySelector('.buttons').style.width = "0px";
                document.getElementById('close-button').style.transform = "none";
            }
        });
        Close.appendChild(CloseButton);
        ButtonsPHB.appendChild(Close);

        /* Kiss Button */
        UserKiss = document.createElement("div");
        UserKiss.id = "user_kiss";
        UserKiss.classList.add("button");
        UserKiss.onclick = function () { KissUserCommand(data.username) };
        IconKiss = document.createElement("div");
        IconKiss.classList.add("icon");
        IconKiss.classList.add("beijar");
        UserKiss.appendChild(IconKiss);
        TooltipKiss = document.createElement("div");
        TooltipKiss.classList.add("tooltip");
        KissArrow = document.createElement("div");
        KissArrow.classList.add("arrow");
        TooltipKiss.appendChild(KissArrow);
        KissText = document.createElement("div");
        KissText.innerText = String(PHBSettings.texts.interactionMenu.kiss).replace("%username%", data.username);
        TooltipKiss.appendChild(KissText);
        UserKiss.appendChild(TooltipKiss);
        ButtonsPHB.appendChild(UserKiss);

        /* Slime Button */
        UserSlime = document.createElement("div");
        UserSlime.id = "user_slime";
        UserSlime.classList.add("button");
        UserSlime.onclick = function () { SlimeUserCommand(data.username) };
        IconSlime = document.createElement("div");
        IconSlime.classList.add("icon");
        IconSlime.classList.add("slime");
        UserSlime.appendChild(IconSlime);
        TooltipSlime = document.createElement("div");
        TooltipSlime.classList.add("tooltip");
        SlimeArrow = document.createElement("div");
        SlimeArrow.classList.add("arrow");
        TooltipSlime.appendChild(SlimeArrow);
        SlimeText = document.createElement("div");
        SlimeText.innerText = String(PHBSettings.texts.interactionMenu.slime).replace("%username%", data.username);
        TooltipSlime.appendChild(SlimeText);
        UserSlime.appendChild(TooltipSlime);
        ButtonsPHB.appendChild(UserSlime);

        /* Pull Button */
        UserPull = document.createElement("div");
        UserPull.id = "user_Pull";
        UserPull.classList.add("button");
        UserPull.onclick = function () { PullUserCommand(data.username) };
        IconPull = document.createElement("div");
        IconPull.classList.add("icon");
        IconPull.classList.add("puxar");
        UserPull.appendChild(IconPull);
        TooltipPull = document.createElement("div");
        TooltipPull.classList.add("tooltip");
        PullArrow = document.createElement("div");
        PullArrow.classList.add("arrow");
        TooltipPull.appendChild(PullArrow);
        PullText = document.createElement("div");
        PullText.innerText = String(PHBSettings.texts.interactionMenu.pull).replace("%username%", data.username);
        TooltipPull.appendChild(PullText);
        UserPull.appendChild(TooltipPull);
        ButtonsPHB.appendChild(UserPull);

        /* Push Button */
        UserPush = document.createElement("div");
        UserPush.id = "user_Push";
        UserPush.classList.add("button");
        UserPush.onclick = function () { PushUserCommand(data.username) };
        IconPush = document.createElement("div");
        IconPush.classList.add("icon");
        IconPush.classList.add("empurrar");
        UserPush.appendChild(IconPush);
        TooltipPush = document.createElement("div");
        TooltipPush.classList.add("tooltip");
        PushArrow = document.createElement("div");
        PushArrow.classList.add("arrow");
        TooltipPush.appendChild(PushArrow);
        PushText = document.createElement("div");
        PushText.innerText = String(PHBSettings.texts.interactionMenu.push).replace("%username%", data.username);
        TooltipPush.appendChild(PushText);
        UserPush.appendChild(TooltipPush);
        ButtonsPHB.appendChild(UserPush);

        /* Hug Button */
        UserHug = document.createElement("div");
        UserHug.id = "user_Hug";
        UserHug.classList.add("button");
        UserHug.onclick = function () { HugUserCommand(data.username) };
        IconHug = document.createElement("div");
        IconHug.classList.add("icon");
        IconHug.classList.add("abracar");
        UserHug.appendChild(IconHug);
        TooltipHug = document.createElement("div");
        TooltipHug.classList.add("tooltip");
        HugArrow = document.createElement("div");
        HugArrow.classList.add("arrow");
        TooltipHug.appendChild(HugArrow);
        HugText = document.createElement("div");
        HugText.innerText = String(PHBSettings.texts.interactionMenu.hug).replace("%username%", data.username);
        TooltipHug.appendChild(HugText);
        UserHug.appendChild(TooltipHug);
        ButtonsPHB.appendChild(UserHug);

        /* Bomb Button */
        UserBomb = document.createElement("div");
        UserBomb.id = "user_Bomb";
        UserBomb.classList.add("button");
        UserBomb.onclick = function () { BombUserCommand(data.username) };
        IconBomb = document.createElement("div");
        IconBomb.classList.add("icon");
        IconBomb.classList.add("explodir");
        UserBomb.appendChild(IconBomb);
        TooltipBomb = document.createElement("div");
        TooltipBomb.classList.add("tooltip");
        BombArrow = document.createElement("div");
        BombArrow.classList.add("arrow");
        TooltipBomb.appendChild(BombArrow);
        BombText = document.createElement("div");
        BombText.innerText = String(PHBSettings.texts.interactionMenu.bomb).replace("%username%", data.username);
        TooltipBomb.appendChild(BombText);
        UserBomb.appendChild(TooltipBomb);
        ButtonsPHB.appendChild(UserBomb);

        /* Sex Button 
        UserSex = document.createElement("div");
        UserSex.id = "user_Sex";
        UserSex.classList.add("button");
        UserSex.onclick = function () { SexUserCommand(data.username) };
        IconSex = document.createElement("div");
        IconSex.classList.add("icon");
        IconSex.classList.add("sexo");
        UserSex.appendChild(IconSex);
        TooltipSex = document.createElement("div");
        TooltipSex.classList.add("tooltip");
        SexArrow = document.createElement("div");
        SexArrow.classList.add("arrow");
        TooltipSex.appendChild(SexArrow);
        SexText = document.createElement("div");
        SexText.innerText = String(PHBSettings.texts.interactionMenu.sex).replace("%username%", data.username);
        TooltipSex.appendChild(SexText);
        UserSex.appendChild(TooltipSex);
        ButtonsPHB.appendChild(UserSex);*/
		
		if(myAccount.rank_effect != 0){
			/* Effect Button */
			UserEffect = document.createElement("div");
			UserEffect.id = "user_enable";
			UserEffect.classList.add("button");
			UserEffect.onclick = function () { EnableCommand() };
			IconEnable = document.createElement("div");
			IconEnable.classList.add("icon");
			IconEnable.classList.add("enable");
			UserEffect.appendChild(IconEnable);
			TooltipSex = document.createElement("div");
			TooltipSex.classList.add("tooltip");
			EnableArrow = document.createElement("div");
			EnableArrow.classList.add("arrow");
			TooltipSex.appendChild(EnableArrow);
			EnableText = document.createElement("div");
			EnableText.innerText = String(PHBSettings.texts.interactionMenu.enable);
			TooltipSex.appendChild(EnableText);
			UserEffect.appendChild(TooltipSex);
			ButtonsPHB.appendChild(UserEffect);
		}
		
        document.getElementById("PHBPluginUserInteractionMenu").innerHTML = "";
        document.getElementById("PHBPluginUserInteractionMenu").appendChild(ButtonsPHB);
    }

    function ImageCommand(data) {
        document.getElementById("PHBPlugin-ImageContainer").innerHTML = "";
        ImageContainer = document.createElement("div");
        ImageContainer.classList.add("illumina-box");
        ImageContainer.classList.add("center");
        ImageContainer.classList.add("ui-draggable");
        ImageContainer.classList.add("ui-draggable-handle");
        ImageContainer.style.zIndex = 9999;
        ImageContainer.style.left = "631px";
        ImageContainer.style.top = "304px";
        ImageContainer.id = "PHBImgContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        ImageContainer.appendChild(ContainerTitle);
        RemoveImage = document.createElement("div");
        RemoveImage.classList.add("illumina-button-close");
        RemoveImage.onclick = function () {
            document.getElementById("PHBPlugin-ImageContainer").innerHTML = "";
        };
        ImageContainer.appendChild(RemoveImage);
        ImgTag = document.createElement("img");
        ImgTag.style.maxHeight = "800px";
        ImgTag.style.maxWidth = "500px";
        ImgTag.src = data.url;
        ImageContainer.appendChild(ImgTag);
        document.getElementById("PHBPlugin-ImageContainer").appendChild(ImageContainer);
        $("#PHBImgContainer").draggable({ containment: "window" });
    }

    function CloseUserInteractionCommand() {
        document.getElementById("PHBPluginUserInteractionMenu").innerHTML = "";
    }

    var MentionCount = 0;
    function MentionCommand(data) {

        if (MentionCount < 1) {
            CloseAllMentions = document.createElement("div");
            CloseAllMentions.id = "ntf6";
            CloseAllMentions.innerText = PHBSettings.texts.mention.closeall;
            CloseAllMentions.style.top = "75px";
            CloseAllMentions.onclick = function () {
                document.getElementById("PHBPlugin-Notifications").innerHTML = "";
                MentionCount = 0;
            };
            document.getElementById("PHBPlugin-Notifications").prepend(CloseAllMentions);
        }

        Mention = document.createElement("div");
        Mention.id = `notifi-${MentionCount}`;
        Mention.classList.add("notifelement");
        Mention.style.left = "20px";
        Mention.style.top = "120px";
        ntf1 = document.createElement("div");
        ntf1.id = "ntf1";
        ntf2 = document.createElement("div");
        ntf2.id = "ntf2";
        ntf1.appendChild(ntf2);
        ntf3 = document.createElement("div");
        ntf3.id = "ntf3";
        Username = document.createElement("u");
        Username.style.textDecoration = "none";
        Username.innerText = myAccount.username == data.username ? PHBSettings.texts.mention.you : data.username;
        ntf3.appendChild(Username);
        ntf1.appendChild(ntf3);
        Mention.appendChild(ntf1);
        ntf4 = document.createElement("div");
        ntf4.id = "ntf4";
        ntf4.innerText = data.message;
        Mention.appendChild(ntf4);
        HideNotif = document.createElement("div");
        HideNotif.style.height = "18px";
        HideNotif.style.width = "5px";
        HideNotif.style.background = "#ec2f26";
        HideNotif.id = "ntf5";
        HideNotif.setAttribute('onclick', `hideMention(${MentionCount})`);
        ntf7 = document.createElement("div");
        ntf7.id = "ntf7";
        HideNotif.appendChild(ntf7);
        Mention.appendChild(HideNotif);
        Follow = document.createElement("div");
        Follow.id = "ntf5";
        if (myAccount.username == data.username)
            Follow.style.display = "none";
        Follow.style.right = "49px";
        Follow.style.height = "18px";
        Follow.style.width = "3px";
        Follow.setAttribute('onclick', `GoToRoomCommand(${data.roomid});hideMention(${MentionCount})`);
        ntf8 = document.createElement("div");
        ntf8.id = "ntf8";
        Follow.appendChild(ntf8);
        Mention.appendChild(Follow);
        Reply = document.createElement("div");
        if (myAccount.username == data.username)
            Reply.style.display = "none";
        Reply.id = "ntf9";
        Reply.setAttribute('onclick', `replyMention("${data.username}");hideMention(${MentionCount})`);
        ntf10 = document.createElement("div");
        ntf10.id = "ntf10";
        Reply.appendChild(ntf10);
        ntf11 = document.createElement("div");
        ntf11.id = "ntf11";
        ntf11.innerText = "Responder";
        Reply.appendChild(ntf11);
        Mention.appendChild(Reply);

        document.getElementById("PHBPlugin-Notifications").prepend(Mention);

        var x = $(`notifi-${MentionCount}`);
        new Audio("https://ws.vicehabbo.fr/notif.mp3").play();
        x.animate({ left: "20px" }, 300);
        var height = x.height() + 145;
        if (MentionCount > 0) {
            $(".notifelement").each(function () {
                if ($(this).attr('id') !== `notifi-${MentionCount}`) {
                    $(this).animate({ top: "+=" + height + "px" }, 250);
                }
            });
        }

        MentionCount++;

    }

    function replyMention(username) {
        sendMessage({ header: "reply_mention", data: { "user": username } });
    }

    function hideMention(id) {
        var x = $("#notifi-" + id);
        var height = x.height() + 60;
        x.remove();
        $(".notifelement").each(function () {
            var txt = $(this).attr('id');
            var numb = txt.match(/\d/g);
            numb = numb.join("");
            if (numb < id) {
                $(this).animate({ top: "-=" + height + "px" }, 250);
            }
        });
        if (MentionCount === 1) {
            document.getElementById("PHBPlugin-Notifications").innerHTML = "";
            MentionCount = 0;
        } else {
            MentionCount--;
        }
    }

    function SetRoomCommand(data) {
        document.getElementById("roomName").innerText = data.roomname;
        document.getElementById("roomId").innerText = data.roomid;
    }

    function OpenYoutubeTvCommand(data) {
        playlist = JSON.parse(data.playlist).phbplugin_video_data;

        TVContainer = document.createElement("div");
        TVContainer.style.color = "black";
        TVContainer.classList.add("illumina-box");
        TVContainer.classList.add("center");
        TVContainer.classList.add("ui-draggable");
        TVContainer.classList.add("ui-draggable-handle");
        TVContainer.style.zIndex = 9999;
        TVContainer.id = "PHBPluginYoutubeTV";
        TVContainer.style.left = "calc(40% - 20%)";
        TVContainer.style.top = "calc(50% - 20%)";

        illuminaboxtitle = document.createElement("div");
        illuminaboxtitle.innerHTML = "&nbsp;";
        illuminaboxtitle.classList.add("illumina-box-title");

        closebutton = document.createElement("div");
        closebutton.classList.add("illumina-button-close");
        closebutton.onclick = function () {
            document.getElementById("PHBPlugin-YoutubeTV").innerHTML = "";
        };

        youtubeFrame = document.createElement("div");
        youtubeFrame.classList.add("youtube_frame");
        youtubeFrame.id = "youtube_frame";

        fundosemvideo = document.createElement("div");
        fundosemvideo.id = "fundo_sem_video";

        centerSelecione = document.createElement("center");
        centerSelecione.style.paddingTop = "34%";
        centerSelecione.style.color = "white";
        centerSelecione.innerText = PHBSettings.texts.youtubetv.select;

        list = document.createElement("div");
        list.classList.add("list_musica");

        scrolltext = document.createElement("div");
        scrolltext.classList.add("scrollbar_txt");
        scrolltext.id = "lista_videos";
        for (var i = 0; i < playlist.length; i++) {
            var video = playlist[i];
            divBox = document.createElement("div");
            divBox.classList.add("box_musica");
            divBox.style.cursor = "pointer";
            divBox.title = PHBSettings.texts.youtubetv.play;
            divBox.onclick = function () {
                document.getElementById("youtube_frame").innerHTML = "<iframe class=\"youtube\" width=\"431\" height=\"302\" src=\"https://www.youtube.com/embed/" + video.video_id + "?autoplay=1\&origin=" + location.hostname + "\" allow=\"autoplay;\"></iframe>";
            };
            PTitle = document.createElement("p");
            PTitle.classList.add("txt_1");
            PTitle.style.marginTop = "0px";
            PTitle.style.fontFamily = "verdana";
            PTitle.style.fontSize = "smaller";
            BTitle = document.createElement("b");
            BTitle.innerText = doTruncarStr(video.video_titulo, 30);
            PTitle.appendChild(BTitle);
            LineBreak = document.createElement("br");
            PTitle.appendChild(LineBreak);
            TChannel = document.createElement("t");
            TChannel.classList.add("txt_2");
            TChannel.innerText = doTruncarStr(video.video_canal, 30);
            PTitle.appendChild(TChannel);
            divBox.appendChild(PTitle);
            scrolltext.appendChild(divBox);
        }
        list.appendChild(scrolltext);
        fundosemvideo.appendChild(centerSelecione);
        youtubeFrame.appendChild(fundosemvideo);
        TVContainer.appendChild(closebutton);
        TVContainer.appendChild(illuminaboxtitle);
        TVContainer.appendChild(youtubeFrame);
        TVContainer.appendChild(list);

        document.getElementById("PHBPlugin-YoutubeTV").appendChild(TVContainer);
        $("#PHBPluginYoutubeTV").draggable({ containment: "window" });
    }

    function doTruncarStr(str, size) {
        if (str == undefined || str == 'undefined' || str == '' || size == undefined || size == 'undefined' || size == '') {
            return str;
        }
        var shortText = str;
        if (str.length >= size + 3) {
            shortText = str.substring(0, size).concat('...');
        }
        return shortText;
    }

    addEventListener('keyup', function (event) {
        if (!PHBSettings.functions.walk_with_keys) return;
        switch (event.keyCode) {
            case 37:
                sendMessage({ header: "move_avatar", data: { "direction": "left" } });
                break;
            case 38:
                sendMessage({ header: "move_avatar", data: { "direction": "up" } });
                break;
            case 39:
                sendMessage({ header: "move_avatar", data: { "direction": "right" } });
                break;
            case 40:
                sendMessage({ header: "move_avatar", data: { "direction": "down" } });
                break;
        }
    });

    function OpenPaymentCommand(data) {
        document.getElementById("PHBPlugin-PaymentContainer").innerHTML = "";
        PaymentContainer = document.createElement("div");
        PaymentContainer.style.color = "black";
        PaymentContainer.classList.add("illumina-box");
        PaymentContainer.classList.add("center");
        PaymentContainer.classList.add("ui-draggable");
        PaymentContainer.classList.add("ui-draggable-handle");
        PaymentContainer.style.zIndex = 9999;
        PaymentContainer.style.left = "631px";
        PaymentContainer.style.top = "304px";
        PaymentContainer.id = "PHBPaymentContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        PaymentContainer.appendChild(ContainerTitle);
        RemovePayment = document.createElement("div");
        RemovePayment.classList.add("illumina-button-close");
        RemovePayment.onclick = function () {
            document.getElementById("PHBPlugin-PaymentContainer").innerHTML = "";
        };
        PaymentContainer.appendChild(RemovePayment);
        TextPayment = document.createElement("h3");
        TextPayment.innerText = `Hubbiz Store`;
        PaymentContainer.appendChild(TextPayment);

        ProductText = document.createElement("p");
        ProductText.innerText = `Comprando ${data.item_params.split(';')[1]}`;
        PaymentContainer.appendChild(ProductText);

        ValorText = document.createElement("p");
        ValorText.innerText = `Preço: R$${data.item_params.split(';')[0]}`;
        PaymentContainer.appendChild(ValorText);

        DivPagamento = document.createElement("div");
        DivPagamento.id = "payment_content";

        PaymentGateways = document.createElement("select");
        PaymentGateways.id = "payGateway";
        PaymentGateways.classList.add("selectPHB");

        PayPalOption = document.createElement("option");
        PayPalOption.value = "paypal";
        PayPalOption.innerText = "PayPal";
        PaymentGateways.appendChild(PayPalOption);

        PixOption = document.createElement("option");
        PixOption.value = "pix";
        PixOption.innerText = "Pix (Brazil)";
        PaymentGateways.appendChild(PixOption);

        PicPayOption = document.createElement("option");
        PicPayOption.value = "picpay";
        PicPayOption.innerText = "PicPay (Brazil)";
        PaymentGateways.appendChild(PicPayOption);

        BoletoOption = document.createElement("option");
        BoletoOption.value = "boleto";
        BoletoOption.innerText = "Boleto Bancário (Brazil)";
        PaymentGateways.appendChild(BoletoOption);

        DivPagamento.appendChild(PaymentGateways);

        LineBreak = document.createElement("br");
        DivPagamento.appendChild(LineBreak);

        PayButton = document.createElement("button");
        PayButton.onclick = function () {
            switch (document.getElementById("payGateway").value) {
                case "paypal":
                    document.getElementById("payment_content").innerHTML = "My PayPal is phbservicesbrasil@gmail.com";
                    break;
                case "picpay":
                    document.getElementById("payment_content").innerHTML = "<img src='https://i.imgur.com/7EHZYml.png' style='width: 250px;padding-bottom: 10px;'><br><img src='https://i.imgur.com/FTeBeJ2.png' style='width: 250px;padding-bottom: 10px;'><br><b style='color: black'>@pedrohb</b>";
                    break;
                case "pix":
                    document.getElementById("payment_content").innerHTML = "<img src='https://i.imgur.com/sAIqZwR.png' style='width: 250px;padding-bottom: 10px;'><br><img src='https://i.imgur.com/wkmsDcm.png' style='width: 250px;padding-bottom: 10px;'><br><b style='color: black'>ad9f3b17-2c90-4859-9792-2aa9281a0192</b>";
                    break;
                case "boleto":
                    document.getElementById("payment_content").innerHTML = "<b style='color: black'>A opção de boletos ainda não é automatizada :(<br>Me envie uma mensagem no Discord para receber o boleto.<br>PedroHB#9569</b>";
                    break;
            }
        };
        PayButton.innerText = "Pay";
        DivPagamento.appendChild(PayButton);

        PaymentContainer.appendChild(DivPagamento);

        document.getElementById("PHBPlugin-PaymentContainer").appendChild(PaymentContainer);
        $("#PHBPaymentContainer").draggable({ containment: "window" });
    }

    function OpenYoutubeMusic(data) {
        document.getElementById("PHBPlugin-YoutubePlayer").innerHTML = "";
        VideoContainer = document.createElement("div");
        VideoContainer.classList.add("illumina-box");
        VideoContainer.classList.add("center");
        VideoContainer.classList.add("ui-draggable");
        VideoContainer.classList.add("ui-draggable-handle");
        VideoContainer.style.zIndex = 9999;
        VideoContainer.style.left = "631px";
        VideoContainer.style.top = "304px";
        VideoContainer.id = "PHBYTContainer";
        ContainerTitle = document.createElement("div");
        ContainerTitle.classList.add("illumina-box-title");
        ContainerTitle.innerHTML = "&nbsp;";
        VideoContainer.appendChild(ContainerTitle);
        RemoveVideo = document.createElement("div");
        RemoveVideo.classList.add("illumina-button-close");
        RemoveVideo.onclick = function () {
            document.getElementById("PHBPlugin-YoutubePlayer").innerHTML = "";
        };
        VideoContainer.appendChild(RemoveVideo);
        IframeTag = document.createElement("iframe");
        IframeTag.width = 350;
        IframeTag.height = 100;
        IframeTag.frameborder = 0;
        IframeTag.src = `https://www.youtube.com/embed/${data.video_id}?autoplay=1&origin=${location.hostname}`;
        VideoContainer.appendChild(IframeTag);
        document.getElementById("PHBPlugin-YoutubePlayer").appendChild(VideoContainer);
        $("#PHBYTContainer").draggable({ containment: "window" });
    }

    function checkselected(value) {
        if (value == 1)
            return "selected";
    }

    function SaveItem() {
        event.preventDefault();
        var form = document.forms.editaritem;
        var elem = form.elements;
        sendMessage({
            header: "save_item",
            data: {
                "id": elem.id.value,
                "sprite_id": elem.sprite_id.value,
                "public_name": elem.public_name.value,
                "item_name": elem.item_name.value,
                "type": elem.type.value,
                "width": elem.item_width.value,
                "length": elem.item_length.value,
                "stack_height": elem.stack_height.value,
                "allow_stack": elem.allow_stack.value,
                "allow_sit": elem.allow_sit.value,
                "allow_lay": elem.allow_lay.value,
                "allow_walk": elem.allow_walk.value,
                "allow_gift": elem.allow_gift.value,
                "allow_trade": elem.allow_trade.value,
                "allow_recycle": elem.allow_recycle.value,
                "allow_marketplace_sell": elem.allow_marketplace_sell.value,
                "allow_inventory_stack": elem.allow_inventory_stack.value,
                "interaction_type": elem.interaction_type.value,
                "interaction_modes_count": elem.interaction_modes_count.value,
                "vending_ids": elem.vending_ids.value,
                "multiheight": elem.multiheight.value,
                "customparams": elem.customparams.value,
                "effect_id_male": elem.effect_id_male.value,
                "effect_id_female": elem.effect_id_female.value,
                "clothing_on_walk": elem.clothing_on_walk.value
            }
        });
        RemoveEditItem();
    }

    function OpenEditItemCommand(baseitem) {
        console.log("[SHOW EDIT ITEM MENU] " + baseitem.id);
        document.getElementById("PHBPlugin-editItem").innerHTML = "<div class=\"illumina-box ui-draggable ui-draggable-handle\" style=\"z-index: 999; left: 631px; top: 304px;\" id=\"editaritem\"><div class=\"illumina-box-title\">&nbsp;</div><div id=\"removeEditar\" onclick=\"RemoveEditItem()\" class=\"illumina-button-close\"></div>" +
            '<form name="editaritem" id="editaritem" onsubmit="return SaveItem()" method="post">' +
            "id: <input type='number' name='id' value='" + baseitem.id + "' disabled>" +
            "sprite_id: <input type='number' name='sprite_id' value='" + baseitem.sprite_id + "'>" +
            "public_name: <input name='public_name' value='" + baseitem.public_name + "'>" +
            "item_name: <input name='item_name' value='" + baseitem.item_name + "'>" +
            "type: <input name='type' value='" + baseitem.type + "'>" +
            "item_width: <input type='number' name='item_width' value='" + baseitem.width + "'>" +
            "item_length: <input type='number' name='item_length' value='" + baseitem.length + "'>" +
            "stack_height: <input name='stack_height' value='" + baseitem.stack_height + "'>" +
            "allow_stack: <select name='allow_stack'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_stack) + ">1</option></select>" +
            "allow_sit: <select name='allow_sit'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_sit) + ">1</option></select>" +
            "allow_lay: <select name='allow_lay'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_lay) + ">1</option></select>" +
            "allow_walk:  <select name='allow_walk'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_walk) + ">1</option></select>" +
            "allow_gift: <select name='allow_gift'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_gift) + ">1</option></select>" +
            "allow_trade: <select name='allow_trade'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_trade) + ">1</option></select>" +
            "allow_recycle: <select name='allow_recycle'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_recycle) + ">1</option></select>" +
            "allow_marketplace_sell: <select name='allow_marketplace_sell'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_marketplace_sell) + ">1</option></select>" +
            "allow_inventory_stack: <select name='allow_inventory_stack'><option value='0'>0</option><option value='1' " + checkselected(baseitem.allow_inventory_stack) + ">1</option></select>" +
            "interaction_type: <input name='interaction_type' value='" + baseitem.interaction_type + "'>" +
            "interaction_modes_count: <input name='interaction_modes_count' value='" + baseitem.interaction_modes_count + "'>" +
            "vending_ids: <input name='vending_ids' value='" + baseitem.vending_ids + "'>" +
            "multiheight: <input name='multiheight' value='" + baseitem.multiheight + "'>" +
            "customparams: <input name='customparams' value='" + baseitem.customparams + "'>" +
            "effect_id_male: <input  type='number' name='effect_id_male' value='" + baseitem.effect_id_male + "'>" +
            "effect_id_female: <input  type='number' name='effect_id_female' value='" + baseitem.effect_id_female + "'>" +
            "clothing_on_walk: <input type='number' name='clothing_on_walk' value='" + baseitem.clothing_on_walk + "'>" +
            "<br><button >Save</button><br></form>" +
            "</div>";
        $("#editaritem").draggable({ containment: "window" });
    }

    function RemoveEditItem() {
        document.getElementById("PHBPlugin-editItem").innerHTML = "";
    }

} catch (ee) {
    console.log(ee);
}