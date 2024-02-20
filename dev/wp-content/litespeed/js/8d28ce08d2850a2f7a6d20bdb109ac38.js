let spectraImageGalleryLoadStatus=!0;const UAGBImageGalleryMasonry={initByOffset(t,a){if(t&&a){t.classList.add("scroll-not-init"),t.classList.add("last-image-not-loaded");var l=t.querySelectorAll("img");if(l.length){const r=l[l.length-1];r.addEventListener("load",()=>{t.classList.remove("last-image-not-loaded"),setTimeout(function(){a.layout()},100)})}let e=null;window.addEventListener("scroll",function(){t.classList.contains("scroll-not-init")&&(clearTimeout(e),UAGBImageGalleryMasonry.presentInViewport(t)&&(t.classList.remove("scroll-not-init"),e=setTimeout(function(){a.layout()},100)))})}},init(l,r,e,t){let o=2;const n=window.innerHeight/1.25,i=document.querySelector(r);let s=null;l.lightboxThumbnails&&(s=new Swiper(r+"+.spectra-image-gallery__control-lightbox .spectra-image-gallery__control-lightbox--thumbnails",t),e={...e,thumbs:{swiper:s}});const c=new Swiper(r+"+.spectra-image-gallery__control-lightbox .spectra-image-gallery__control-lightbox--main",e),g=(c.lazy.load(),loadLightBoxImages(i,c,null,l,s),i?.querySelector(".spectra-image-gallery__control-loader")),a=i?.querySelector(".spectra-image-gallery__control-button");l.feedPagination&&l.paginateUseLoader?window.addEventListener("scroll",function(){let e=i?.querySelector(".spectra-image-gallery__media-wrapper");var t,a=(e=e||i).lastElementChild.getBoundingClientRect().top+window.scrollY;window.pageYOffset+n>=a&&(a={page_number:o},t=l.gridPages,spectraImageGalleryLoadStatus&&(o>t&&(g.style.display="none"),o<=t&&(UAGBImageGalleryMasonry.callAjax(i,a,l,!1,o,r,c,s),o++,spectraImageGalleryLoadStatus=!1)))}):l.feedPagination&&!l.paginateUseLoader&&(a.onclick=function(){var e=l.gridPages,t={total:e,page_number:o};a.classList.add("disabled"),spectraImageGalleryLoadStatus&&o<=e&&(UAGBImageGalleryMasonry.callAjax(i,t,l,!1,o,r,c,s),o++,spectraImageGalleryLoadStatus=!1)})},createElementFromHTML(e){const t=document.createElement("div");e=e.replace(/\s+/gm," ").replace(/( )+/gm," ").trim();return t.innerHTML=e,t},getCustomURL(e,t){const a=new RegExp("^((http|https)://)(www.)?[a-zA-Z0-9@:%._\\+~#?&//=]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&//=]*)$");e=parseInt(e.getAttribute("data-spectra-gallery-image-id"));return a.test(t?.customLinks[e])?t.customLinks[e]:void 0},openCustomURL(e){window.open(e,"_blank")},addClickEvents(e,a){const t=e?.querySelectorAll(".spectra-image-gallery__media-wrapper");t.forEach(e=>{const t=UAGBImageGalleryMasonry.getCustomURL(e,a);t&&(e.style.cursor="pointer",e.addEventListener("click",()=>UAGBImageGalleryMasonry.openCustomURL(t)))})},callAjax(l,r,o,n=!1,i,s,c,g){const e=new FormData;e.append("action","uag_load_image_gallery_masonry"),e.append("nonce",uagb_image_gallery.uagb_image_gallery_masonry_ajax_nonce),e.append("page_number",r.page_number),e.append("attr",JSON.stringify(o)),fetch(uagb_image_gallery.ajax_url,{method:"POST",credentials:"same-origin",body:e}).then(e=>e.json()).then(function(t){let a=l?.querySelector(".spectra-image-gallery__layout--masonry");a=a||l,setTimeout(function(){const e=new Isotope(a,{itemSelector:".spectra-image-gallery__media-wrapper--isotope",stagger:10});e.insert(UAGBImageGalleryMasonry.createElementFromHTML(t.data)),imagesLoaded(a).on("progress",function(){e.layout()}),imagesLoaded(a).on("always",function(){const e=document.querySelector(s),t=e?.querySelector(".spectra-image-gallery__control-button");t?.classList?.remove("disabled"),loadLightBoxImages(e,c,null,o,g)}),"url"===o.imageClickEvent&&o.customLinks&&UAGBImageGalleryMasonry.addClickEvents(a,o),(spectraImageGalleryLoadStatus=!0)===n&&l?.querySelector(".spectra-image-gallery__control-button").classList.toggle("disabled"),i===parseInt(r.total)&&(l.querySelector(".spectra-image-gallery__control-button").style.opacity=0,setTimeout(()=>{l.querySelector(".spectra-image-gallery__control-button").parentElement.style.display="none"},2e3))},500)})},presentInViewport(e){e=e.getBoundingClientRect();return 0<=e.top&&0<=e.left&&e.bottom<=(window.innerHeight||document.documentElement.clientHeight)&&e.right<=(window.innerWidth||document.documentElement.clientWidth)}},UAGBImageGalleryPagedGrid={init(r,o,e,t){let n=1;const i=document.querySelector(o);let s=null;r.lightboxThumbnails&&(s=new Swiper(o+"+.spectra-image-gallery__control-lightbox .spectra-image-gallery__control-lightbox--thumbnails",t),e={...e,thumbs:{swiper:s}});const c=new Swiper(o+"+.spectra-image-gallery__control-lightbox .spectra-image-gallery__control-lightbox--main",e),g=(c.lazy.load(),loadLightBoxImages(i,c,n,r,s),i?.querySelectorAll(".spectra-image-gallery__control-arrows--grid")),a=i?.querySelectorAll(".spectra-image-gallery__control-dot");for(let e=0;e<g.length;e++)g[e].addEventListener("click",e=>{const t=e.currentTarget;let a=n;switch(t.getAttribute("data-direction")){case"Prev":--a;break;case"Next":++a}i?.querySelector(".spectra-image-gallery__media-wrapper")||i;var e=r.gridPages,l={page_number:a,total:e};a===e||1===a?t.disabled=!0:g.forEach(e=>{e.disabled=!1}),a<=e&&1<=a&&(UAGBImageGalleryPagedGrid.callAjax(i,l,r,g,o,c,s),n=a)});for(let e=0;e<a.length;e++)a[e].addEventListener("click",e=>{const t=e.currentTarget;var e=t.getAttribute("data-go-to"),a=(i?.querySelector(".spectra-image-gallery__media-wrapper")||i,{page_number:e,total:r.gridPages});UAGBImageGalleryPagedGrid.callAjax(i,a,r,g,o,c,s),n=e})},createElementFromHTML(e){const t=document.createElement("div");e=e.replace(/\s+/gm," ").replace(/( )+/gm," ").trim();return t.innerHTML=e,t},getCustomURL(e,t){const a=new RegExp("^((http|https)://)(www.)?[a-zA-Z0-9@:%._\\+~#?&//=\\-]{2,256}\\.[a-z]{2,6}\\b([-a-zA-Z0-9@:%._\\+~#?&//=]*)$");e=parseInt(e.getAttribute("data-spectra-gallery-image-id"));return a.test(t?.customLinks[e])?t.customLinks[e]:void 0},openCustomURL(e){window.open(e,"_blank")},addClickEvents(e,a){const t=e?.querySelectorAll(".spectra-image-gallery__media-wrapper");t.forEach(e=>{const t=UAGBImageGalleryPagedGrid.getCustomURL(e,a);t&&(e.style.cursor="pointer",e.addEventListener("click",()=>UAGBImageGalleryPagedGrid.openCustomURL(t)))})},callAjax(o,n,i,s,c,g,d){const e=new FormData;e.append("action","uag_load_image_gallery_grid_pagination"),e.append("nonce",uagb_image_gallery.uagb_image_gallery_grid_pagination_ajax_nonce),e.append("page_number",n.page_number),e.append("attr",JSON.stringify(i)),fetch(uagb_image_gallery.ajax_url,{method:"POST",credentials:"same-origin",body:e}).then(e=>e.json()).then(function(r){!1!==r.success&&setTimeout(function(){let e=o?.querySelector(".spectra-image-gallery__layout--isogrid");const t=(e=e||o).querySelectorAll(".spectra-image-gallery__media-wrapper--isotope"),a=new Isotope(e,{itemSelector:".spectra-image-gallery__media-wrapper--isotope",layoutMode:"fitRows"}),l=(t.forEach(e=>{a.remove(e),a.layout()}),a.insert(UAGBImageGalleryPagedGrid.createElementFromHTML(r.data)),imagesLoaded(e).on("progress",function(){a.layout()}),imagesLoaded(e).on("always",function(){var e=document.querySelector(c);loadLightBoxImages(e,g,parseInt(n.page_number),i,d)}),i.customLinks&&UAGBImageGalleryPagedGrid.addClickEvents(e,i),1===parseInt(n.page_number)?s.forEach(e=>{e.disabled="Prev"===e.getAttribute("data-direction")}):parseInt(n.page_number)===parseInt(n.total)?s.forEach(e=>{e.disabled="Next"===e.getAttribute("data-direction")}):s.forEach(e=>{e.disabled=!1}),o?.querySelector(".spectra-image-gallery__control-dot--active").classList.toggle("spectra-image-gallery__control-dot--active"),o?.querySelectorAll(".spectra-image-gallery__control-dot"));l[parseInt(n.page_number)-1].classList.toggle("spectra-image-gallery__control-dot--active")},500)})}},loadLightBoxImages=(l,r,e,o,n)=>{if(l){const t=o.paginateLimit,a=document.querySelector("body"),i=(r.on("activeIndexChange",e=>{if(o.lightboxThumbnails&&n.slideTo(e.activeIndex),o.lightboxDisplayCount){e=e.activeIndex;const t=l?.nextElementSibling,a=t.querySelector(".spectra-image-gallery__control-lightbox--count-page");a&&(a.innerHTML=parseInt(e)+1)}r.lazy.load()}),o.lightboxThumbnails&&n.on("activeIndexChange",e=>{r.slideTo(e.activeIndex)}),l?.nextElementSibling);if(i&&i?.classList.contains("spectra-image-gallery__control-lightbox")){if(i.addEventListener("keydown",e=>{27===e.keyCode&&(a.style.overflow="",i.style.opacity=0,setTimeout(()=>{i.style.display="none"},250))}),i.style.display="none",o.lightboxCloseIcon){const c=i.querySelector(".spectra-image-gallery__control-lightbox--close");c&&c.addEventListener("click",()=>{a.style.overflow="",i.style.opacity=0,setTimeout(()=>{i.style.display="none"},250)})}if(o.lightboxDisplayCount){const g=i.querySelector(".spectra-image-gallery__control-lightbox--count-total");g.innerHTML=o.mediaGallery.length}}const s=e=>{r&&i&&(i.style.display="",i.focus(),setTimeout(()=>{r.slideTo(e)},100),setTimeout(()=>{i.style.opacity=1,i?.classList.contains("spectra-image-gallery__control-lightbox")&&(a.style.overflow="hidden")},250))};null!==e?setTimeout(()=>{addClickListeners(l,e,s,t,o)},1e3):addClickListeners(l,null,s,null,o)}},addClickListeners=(e,o,n,i,s)=>{const t=e.querySelectorAll(".spectra-image-gallery__media-wrapper"),c={};if("image"===s.imageClickEvent){const a=s.mediaGallery;a.forEach(e=>{c[e.id]=e.url})}t.forEach((e,t)=>{if(e.style.cursor="pointer","image"===s.imageClickEvent){var a=e.getAttribute("data-spectra-gallery-image-id");const l=c[a];e.addEventListener("click",()=>{openImageInWindow(l)})}else{const r=null!==o?t+(o-1)*i:t;e.addEventListener("click",()=>n(r))}})};let imageWindow=null;const openImageInWindow=e=>{imageWindow&&!imageWindow.closed?imageWindow.focus():imageWindow=window.open(e,"_blank")};
;