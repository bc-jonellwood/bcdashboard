import{a as V,t as Y}from"../chunks/disclose-version.Dt6YuCZi.js";import{i as re}from"../chunks/legacy.TGj7z1RG.js";import{o as ze,B as Le,x as N,A as ie,z as Re,i as Ce,an as Ee,O as He,P as we,Q as oe,y as J,as as ee,R as Te,C as ke,V as Be,v as ge,at as me,au as Ve,am as Ye,av as Ue,F as Ge,q as Xe,aj as Ke,ad as Qe,Y as We,aw as fe,ax as ve,a9 as Je,I as ye,ay as qe,az as Ze,aA as je,ah as $e,aB as et,aC as tt,N as at,aD as rt,b as nt,X as st,p as ne,m as F,s as I,n as D,t as j,k as se,aE as De,aF as Ie,j as te,g as v,aG as lt,aH as P,e as it,a8 as ot,K as q,aI as de,aJ as ct,aq as dt}from"../chunks/runtime.81itCKzL.js";import{a as ut,l as ft,b as vt,w as ht,e as Z,s as K}from"../chunks/render.yrP3vjwa.js";import{p as y,b as _t,i as ce}from"../chunks/props.0Cu2CR9m.js";import{c as wt,o as gt}from"../chunks/index-client.hhUygu-f.js";function Fe(t,e){return e}function mt(t,e,a,r){for(var n=[],s=e.length,o=0;o<s;o++)Ve(e[o].e,n,!0);var _=s>0&&n.length===0&&a!==null;if(_){var u=a.parentNode;Ye(u),u.append(a),r.clear(),L(t,e[0].prev,e[s-1].next)}Ue(n,()=>{for(var w=0;w<s;w++){var i=e[w];_||(r.delete(i.k),L(t,i.prev,i.next)),Ge(i.e,!_)}})}function Me(t,e,a,r,n,s=null){var o=t,_={flags:e,items:new Map,first:null},u=(e&qe)!==0;if(u){var w=t;o=N?ie(Xe(w)):w.appendChild(ze())}N&&Re();var i=null,f=!1;Le(()=>{var g=a(),l=Ce(g)?g:g==null?[]:Ee(g),c=l.length;if(f&&c===0)return;f=c===0;let d=!1;if(N){var p=o.data===He;p!==(c===0)&&(o=we(),ie(o),oe(!1),d=!0)}if(N){for(var b=null,x,T=0;T<c;T++){if(J.nodeType===8&&J.data===Ke){o=J,d=!0,oe(!1);break}var k=l[T],h=r(k,T);x=Ne(J,_,b,null,k,h,T,n,e),_.items.set(h,x),b=x}c>0&&ie(we())}if(!N){var m=Qe;yt(l,_,o,n,e,(m.f&ee)!==0,r)}s!==null&&(c===0?i?Te(i):i=ke(()=>s(o)):i!==null&&Be(i,()=>{i=null})),d&&oe(!0),a()}),N&&(o=J)}function yt(t,e,a,r,n,s,o,_){var A,E,z,G;var u=(n&Ze)!==0,w=(n&(fe|ve))!==0,i=t.length,f=e.items,g=e.first,l=g,c,d=null,p,b=[],x=[],T,k,h,m;if(u)for(m=0;m<i;m+=1)T=t[m],k=o(T,m),h=f.get(k),h!==void 0&&((A=h.a)==null||A.measure(),(p??(p=new Set)).add(h));for(m=0;m<i;m+=1){if(T=t[m],k=o(T,m),h=f.get(k),h===void 0){var le=l?l.e.nodes_start:a;d=Ne(le,e,d,d===null?e.first:d.next,T,k,m,r,n),f.set(k,d),b=[],x=[],l=d.next;continue}if(w&&At(h,T,m,n),h.e.f&ee&&(Te(h.e),u&&((E=h.a)==null||E.unfix(),(p??(p=new Set)).delete(h))),h!==l){if(c!==void 0&&c.has(h)){if(b.length<x.length){var R=x[0],M;d=R.prev;var Q=b[0],U=b[b.length-1];for(M=0;M<b.length;M+=1)Ae(b[M],R,a);for(M=0;M<x.length;M+=1)c.delete(x[M]);L(e,Q.prev,U.next),L(e,d,Q),L(e,U,R),l=R,d=U,m-=1,b=[],x=[]}else c.delete(h),Ae(h,l,a),L(e,h.prev,h.next),L(e,h,d===null?e.first:d.next),L(e,d,h),d=h;continue}for(b=[],x=[];l!==null&&l.k!==k;)(s||!(l.e.f&ee))&&(c??(c=new Set)).add(l),x.push(l),l=l.next;if(l===null)continue;h=l}b.push(h),d=h,l=h.next}if(l!==null||c!==void 0){for(var O=c===void 0?[]:Ee(c);l!==null;)(s||!(l.e.f&ee))&&O.push(l),l=l.next;var W=O.length;if(W>0){var S=n&qe&&i===0?a:null;if(u){for(m=0;m<W;m+=1)(z=O[m].a)==null||z.measure();for(m=0;m<W;m+=1)(G=O[m].a)==null||G.fix()}mt(e,O,S,f)}}u&&We(()=>{var X;if(p!==void 0)for(h of p)(X=h.a)==null||X.apply()}),ge.first=e.first&&e.first.e,ge.last=d&&d.e}function At(t,e,a,r){r&fe&&me(t.v,e),r&ve?me(t.i,a):t.i=a}function Ne(t,e,a,r,n,s,o,_,u,w){var i=(u&fe)!==0,f=(u&je)===0,g=i?f?Je(n):ye(n):n,l=u&ve?ye(o):o,c={i:l,v:g,k:s,a:null,e:null,prev:a,next:r};try{return c.e=ke(()=>_(t,g,l),N),c.e.prev=a&&a.e,c.e.next=r&&r.e,a===null?e.first=c:(a.next=c,a.e.next=c.e),r!==null&&(r.prev=c,r.e.prev=c.e),c}finally{}}function Ae(t,e,a){for(var r=t.next?t.next.e.nodes_start:a,n=e?e.e.nodes_start:a,s=t.e.nodes_start;s!==r;){var o=$e(s);n.before(s),s=o}}function L(t,e,a){e===null?t.first=a:(e.next=a,e.e.next=a&&a.e),a!==null&&(a.prev=e,a.e.prev=e&&e.e)}function bt(t){if(N){var e=!1,a=()=>{if(!e){if(e=!0,t.hasAttribute("value")){var r=t.value;$(t,"value",null),t.value=r}if(t.hasAttribute("checked")){var n=t.checked;$(t,"checked",null),t.checked=n}}};t.__on_r=a,et(a),ut()}}function $(t,e,a,r){var n=t.__attributes??(t.__attributes={});N&&(n[e]=t.getAttribute(e),e==="src"||e==="srcset"||e==="href"&&t.nodeName==="LINK")||n[e]!==(n[e]=a)&&(e==="style"&&"__styles"in t&&(t.__styles={}),e==="loading"&&(t[tt]=a),a==null?t.removeAttribute(e):typeof a!="string"&&pt(t).includes(e)?t[e]=a:t.setAttribute(e,a))}var be=new Map;function pt(t){var e=be.get(t.nodeName);if(e)return e;be.set(t.nodeName,e=[]);for(var a,r=t,n=Element.prototype;n!==r;){a=rt(r);for(var s in a)a[s].set&&e.push(s);r=at(r)}return e}function St(t,e,a=e){ft(t,"change",r=>{var n=r?t.defaultChecked:t.checked;a(n)}),(N&&t.defaultChecked!==t.checked||nt(e)==null)&&a(t.checked),st(()=>{var r=e();t.checked=!!r})}function pe(t,e){vt(window,["resize"],()=>ht(()=>e(window[t])))}function xt(t,e){var s;var a=(s=t.$$events)==null?void 0:s[e.type],r=Ce(a)?a.slice():a==null?[]:[a];for(var n of r)n.call(this,e)}var Ct=Y('<label class="svelte-1pghddc"><input type="checkbox" class="svelte-1pghddc"> <span class="svelte-1pghddc"> </span></label>');function Et(t,e){ne(e,!1);let a=y(e,"choice",8),r=y(e,"isSelected",12),n=y(e,"onselect",8);function s(){n()(a(),!r())}function o(f){f.key==="Enter"&&n()(a(),!r())}re();var _=Ct(),u=F(_);bt(u);var w=I(u,2),i=F(w,!0);D(w),D(_),j(()=>K(i,a())),St(u,r),Z("click",u,s),Z("keydown",u,o),V(t,_),se()}var Tt=Y('<div class="question svelte-1b4m7pf"><p class="qNum svelte-1b4m7pf"> </p> <p class="gradient-border svelte-1b4m7pf"> </p> <!></div> <div class="correct-answer hidden svelte-1b4m7pf">X</div> <div class="wrong-answer hidden svelte-1b4m7pf">X</div>',1);function kt(t,e){ne(e,!1);const a=P();let r=y(e,"question",8),n=y(e,"choices",8);y(e,"correctAnswer",8);let s=y(e,"index",8),o=y(e,"selectedAnswer",8),_=y(e,"onselectAnswer",8);function u(p){_()(new CustomEvent("selectAnswer",{detail:p}))}De(()=>it(n()),()=>{q(a,[...n()].sort(()=>Math.random()-.5))}),Ie(),re();var w=Tt(),i=te(w),f=F(i),g=F(f,!0);D(f);var l=I(f,2),c=F(l,!0);D(l);var d=I(l,2);Me(d,1,()=>v(a),Fe,(p,b)=>{var x=ot(()=>o()===v(b));Et(p,{get choice(){return v(b)},get isSelected(){return v(x)},onselect:u})}),D(i),lt(4),j(()=>{$(i,"id",s()),K(g,s()+1),K(c,r())}),V(t,w),se()}const B=[{index:0,question:"The State Fleet card is used to purchase:",choices:["Fuel and Oil","Snacks","Fuel Only"],correctAnswer:"Fuel Only",manualSection:"0.0.0"},{index:1,question:"The State Fleet card can be used in:",choices:["Personal Vehicle","County Vehicle","Both"],correctAnswer:"Both",manualSection:"0.0.0"},{index:2,question:"All State Fleet receipts should provide:",choices:["Vehicle and Tag Number, office or agency head","Vendor Name/Address","Cost/Gallons","All of these"],correctAnswer:"All of these",manualSection:"0.0.0"},{index:3,question:"How many days do you have to dispute a transaction from the date of purchase?",choices:["15 Days","30 Days","45 Days"],correctAnswer:"15 Days",manualSection:"0.0.0"},{index:4,question:"The State Fleet user must turn their receipts in to their:",choices:["Department Liaison","Finance","Procurement Director"],correctAnswer:"Department Liaison",manualSection:"0.0.0"},{index:5,question:"The State Fleet card should be used as a secondary use to purchase fuel. The County fuel system is always the primary.",choices:["True","False"],correctAnswer:"True",manualSection:"0.0.0"},{index:6,question:"The State Fleet card can be used for personal use.",choices:["True","False"],correctAnswer:"False",manualSection:"0.0.0"},{index:7,question:"If your fuel card is misplaced, lost or stolen contact the Fuel Card Administrator in the Fleet Management Dept.",choices:["True","False"],correctAnswer:"True",manualSection:"0.0.0"},{index:8,question:"If a receipt is lost or misplaced; the user must write a detailed memo stating all information from the transaction (location purchased, gallons, cost, vehicle number and tag number).",choices:["True","False"],correctAnswer:"True",manualSection:"0.0.0"},{index:9,question:"If purchasing unleaded fuel, mid-grade or premium is okay.",choices:["True","False"],correctAnswer:"False",manualSection:"0.0.0"}],ue=Math.PI/180,Se=2,xe=1,ae=20,qt=["hotpink","gold","dodgerblue","tomato","rebeccapurple","lightgreen","turquoise"],C=(t,e=0)=>Math.random()*(t-e)+e,Dt=(t,e,a,r,n,s,o)=>{let _,u,w,i,f,g,l,c=s[Math.floor(C(s.length))],d=C(90,-90);e?(u=e[0],w=e[1],i=C(a,5),f=C(a,5),_=C(r+n/2,r-n/2)*ue,d*=2):(u=C(t.canvas.width),w=C(-ae),i=C(5),f=C(5,1),_=C(180)*ue),g=Math.cos(_),l=Math.sin(_);let p={dead:!1,life:0,delay:0,x:u,y:w,angle:C(360),da:d,dx:g*i,dy:l*f,w:C(18,10),h:C(6,4),gx:0,gy:C(4.5,2),xw:C(6,1),style:c};return o&&(p=o(p)),p},It=(t,e)=>{e.dead||e.life<e.delay||(t.save(),t.translate(e.x,e.y),t.rotate(e.angle*ue),e.style instanceof HTMLImageElement?t.drawImage(e.style,-e.style.width/2,-e.style.height/2):(t.fillStyle=e.style,t.beginPath(),t.rect(e.w*-.5,e.h*-.5,e.w,e.h),t.fill()),t.restore())},Ft=(t,e)=>{t.life+=e,!(t.dead||t.life<t.delay)&&(t.angle+=t.da*e*Se,t.dy+=t.gy*e*Se,t.dx+=C(4,2)*Math.sin(t.life*t.xw)*e,t.dx*=.98,t.dy*=.98,t.x+=t.dx*xe,t.y+=t.dy*xe)},Mt=(t,e)=>e.x<-ae||e.x>t.canvas.width+ae||e.y>t.canvas.height+ae,Nt=(t,e)=>{t.clearRect(0,0,t.canvas.width,t.canvas.height);for(let a=0;a<e.length;++a)It(t,e[a])},Pt=(t,e,a,r)=>{let n=e.length;for(let s=0;s<e.length;++s){const o=e[s];o.dead?n--:(Ft(o,a),Mt(t,o)&&(o.dead=!0),r&&r(o,a))}return n>0},Ot=(t,e,a,r,n,s,o,_,u,w)=>{const i=t.getContext("2d");if(!i)throw new Error("No context?");const f=Array.from({length:a},()=>Dt(i,r,n,s,o,_,u));let g,l;const c=d=>{Nt(i,f),Pt(i,f,(d-l)/1e3,w)?(l=d,g=requestAnimationFrame(c)):e()};return l=performance.now(),g=requestAnimationFrame(c),()=>{cancelAnimationFrame(g)}};var zt=Y('<canvas class="svelte-1efe31a"></canvas>');function Lt(t,e){ne(e,!1);let a=y(e,"styles",8,qt),r=y(e,"particleCount",8,50),n=y(e,"origin",8,void 0),s=y(e,"force",8,15),o=y(e,"angle",8,0),_=y(e,"spread",8,360),u=y(e,"onCreate",8,void 0),w=y(e,"onUpdate",8,void 0);const i=wt();let f=P(),g=P(),l=P();gt(()=>(de(f,v(f).width=v(g)),de(f,v(f).height=v(l)),Ot(v(f),()=>i("completed"),r(),n(),s(),o(),_(),a(),u(),w()))),re();var c=zt();_t(c,d=>q(f,d),()=>v(f)),j(()=>{$(c,"width",v(g)),$(c,"height",v(l))}),pe("innerWidth",d=>q(g,d)),pe("innerHeight",d=>q(l,d)),V(t,c),se()}function Rt(t,e){let a=y(e,"origin",8),r=y(e,"styles",8,void 0),n=y(e,"particleCount",8,50),s=y(e,"force",8,15),o=y(e,"angle",24,()=>-90),_=y(e,"spread",8,360),u=y(e,"onCreate",8,void 0),w=y(e,"onUpdate",8,void 0);Lt(t,{get particleCount(){return n()},get origin(){return a()},get force(){return s()},get spread(){return _()},get angle(){return o()},get styles(){return r()},get onCreate(){return u()},get onUpdate(){return w()},$$events:{completed(i){xt.call(this,e,i)}}})}var Ht=Y('<!> <p class="answer svelte-10lw60z"> </p>',1),Bt=Y('<button class="svelte-10lw60z">Submit</button> <button class="svelte-10lw60z">Reset</button>',1),Vt=Y('<p class="svelte-10lw60z">Your score has been submitted. You may close this window now.</p>'),Yt=Y('<div class="body svelte-10lw60z"><div class="mute svelte-10lw60z"><h2 class="svelte-10lw60z">Motor Pool Test</h2> <div class="questions svelte-10lw60z"></div> <div class="buttons svelte-10lw60z"><!> <!> <!></div> <p class="score svelte-10lw60z"> </p></div></div> <div class="messagePopover svelte-10lw60z" name="messagePopover" id="messagePopover" popover="manual"> <div class="arrow svelte-10lw60z"><button popovertarget="messagePopover" popovertargetaction="hide" class="svelte-10lw60z">Close</button></div></div>',1);function Jt(t,e){ne(e,!1);const a=async()=>{q(r,!1),await dt(),q(r,!0)};let r=P(!1),n=P(new Array(B.length).fill(null)),s=P(0),o=B.length,_=o*.8,u=P(!1),w=[],i=P("");function f(){q(s,0);for(let A=0;A<v(n).length;A++){let E=v(n)[A],z=B[A].correctAnswer,G=B[A].index,X=B[A].manualSection,H=document.getElementById(G);E===z?(H.classList.add("correct-answer"),H.classList.remove("wrong-answer"),ct(s)):(w.push({manualSection:X}),H.classList.remove("correct-answer"),H.classList.add("wrong-answer"))}if(v(s)>=_&&(a(),q(u,!0)),v(s)<_){var S=document.getElementById("messagePopover");q(i,v(i)+"You did not pass the test. Please try again after studying manual sections:");for(let A=0;A<w.length;A++)q(i,v(i)+(`
`+w[A].manualSection+","));return S.setAttribute("data-content",v(i)),S.showPopover(),v(i)}}function g(){document.querySelectorAll("div.wrong-answer").forEach(E=>{E.classList.remove("wrong-answer")}),q(n,new Array(B.length).fill(null)),q(s,0),document.querySelectorAll("div.correct-answer").forEach(E=>{E.classList.remove("correct-answer")}),q(i,"")}De(()=>v(s),()=>{v(s)}),Ie(),re();var l=Yt(),c=te(l),d=F(c),p=I(F(d),2);Me(p,5,()=>B,Fe,(S,A,E)=>{let z=()=>v(A).question,G=()=>v(A).choices,X=()=>v(A).correctAnswer;var H=Ht(),he=te(H);kt(he,{get question(){return z()},get choices(){return G()},index:E,get selectedAnswer(){return v(n)[E]},onselectAnswer:Oe=>de(n,v(n)[E]=Oe.detail)});var _e=I(he,2),Pe=F(_e);D(_e),j(()=>K(Pe,`Answer: ${X()??""}`)),V(S,H)}),D(p);var b=I(p,2),x=F(b);{var T=S=>{var A=Bt(),E=te(A),z=I(E,2);Z("click",E,f),Z("click",z,g),V(S,A)};ce(x,S=>{v(u)||S(T)})}var k=I(x,2);{var h=S=>{var A=Vt();V(S,A)};ce(k,S=>{v(u)&&S(h)})}var m=I(k,2);{var le=S=>{Rt(S,{origin:[window.innerWidth/2,window.innerHeight],angle:-90,spread:35,force:35})};ce(m,S=>{v(r)&&S(le)})}D(b);var R=I(b,2),M=F(R);D(R),D(d),D(c);var Q=I(c,2),U=F(Q),O=I(U),W=F(O);D(O),D(Q),j(()=>{K(M,`Score: ${v(s)??""} of ${o??""}`),K(U,`${v(i)??""} `)}),Z("click",W,g),V(t,l),se()}export{Jt as component};
