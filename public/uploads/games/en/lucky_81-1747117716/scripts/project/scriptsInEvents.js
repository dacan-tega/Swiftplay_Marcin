

const scriptsInEvents = {

	async Fullscreen_Event2_Act1(runtime, localVars)
	{
		const w1 = window.innerWidth;
		const h1 = window.innerHeight;
		
		setTimeout(() => {
		  const w2 = window.innerWidth;
		  const h2 = window.innerHeight;
		
		  if (w1 !== w2 || h1 !== h2) {
		        const styles = document.querySelectorAll('style');
		        styles.forEach(style => {
		        if (style.textContent.includes('#scroll-overlay')) {
		            style.remove();
		        }
		        });
		  } else {
		    
		  }
		}, 500);
	},

	async Fullscreen_Event3_Act1(runtime, localVars)
	{
		// Xóa thẻ style chứa CSS của overlay và nền đen
		document.querySelectorAll('style').forEach(style => {
		  const css = style.textContent;
		  if (css.includes('#scroll-overlay') || css.includes('#fullscreen-dark')) {
		    style.remove();
		  }
		});
		
		// Xóa các phần tử div tương ứng
		['scroll-overlay', 'fullscreen-dark'].forEach(id => {
		  const el = document.getElementById(id);
		  if (el) el.remove();
		});
		
	},

	async Fullscreen_Event4_Act1(runtime, localVars)
	{
// Inject CSS with dark background and updated guide
const isIOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;

const style = document.createElement('style');
style.textContent = `
  html, body {
    min-height: 200vh !important;
    overflow-y: scroll !important;
    height: auto !important;
    -webkit-overflow-scrolling: touch;
    margin: 0;
    padding: 0;
  }

  canvas {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    transform: translate(0%, 0%) !important;
    z-index: 10;
    display: block;
    max-width: 100vw;
    max-height: 100vh;
  }

  /* Lớp nền đen mờ */
  #fullscreen-dark {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.8);
    z-index: 99998;
    pointer-events: none;
  }

  /* Lớp vuốt */
  #scroll-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 300vh;
    background: rgba(0, 0, 0, 0.001);
    z-index: 99999;
    overflow-y: scroll;
    -webkit-overflow-scrolling: touch;
    touch-action: auto;
  }

  #scroll-overlay::after {
    content: "${isIOS ? '⬆️ SWIPE UP TO START THE GAME' : '👆 TAP TO ENTER FULLSCREEN'}";
    position: fixed;
    bottom: 10%;
    left: 50%;
    transform: translateX(-50%);
    background: none;
    color: #ffffff;
    padding: 16px 30px;
    border-radius: 30px;
    font-size: 1.2rem;
    font-weight: bold;
    text-transform: uppercase;
    z-index: 100000;
    pointer-events: none;
    animation: bounce 1.5s infinite, pulse 2s infinite;
    text-align: center;
  }

  @keyframes bounce {
    0%, 100% {
      transform: translateX(-50%) translateY(0);
    }
    50% {
      transform: translateX(-50%) translateY(-15px);
    }
  }

  @keyframes pulse {
    0%, 100% {
      opacity: 1;
    }
    50% {
      opacity: 0.6;
    }
  }
`;
document.head.appendChild(style);

// Thêm lớp nền đen mờ
const darkLayer = document.createElement('div');
darkLayer.id = 'fullscreen-dark';
document.body.appendChild(darkLayer);

// Thêm lớp scroll-overlay để vuốt hoặc chạm
const scrollOverlay = document.createElement('div');
scrollOverlay.id = 'scroll-overlay';
document.body.appendChild(scrollOverlay);

	}
};

self.C3.ScriptsInEvents = scriptsInEvents;
