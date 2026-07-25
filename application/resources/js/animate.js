export async function loadAnimate() {
    console.log("Animasi dijalankan!");
    // Note: ensure animate.css is installed via npm
    await import('animate.css'); 
}

// Make it globally accessible
window.loadAnimate = loadAnimate;