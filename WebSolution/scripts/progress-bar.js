function updateProgressBars() {
    const progressCells = document.querySelectorAll("#sortedTable1 .progressBarContainer");
    
    progressCells.forEach(cell => {
        const progressText = cell.querySelector('.progressText');
        const progressBarFill = cell.querySelector('.progressBarFill');
        
        const percentage = parseInt(progressText.textContent);
        
        progressBarFill.style.width = percentage + '%';
    });
}