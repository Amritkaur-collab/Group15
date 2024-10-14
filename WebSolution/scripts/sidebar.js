function setCurrentSidebarBtn()
{
    const sidebarBtns = document.querySelectorAll('#dbsidebar a');

    for(let i = 0; i < sidebarBtns.length; i++)
    {
        if(document.location.href.includes(sidebarBtns[i].href))
        {
            sidebarBtns[i].classList.add('current');
            break;
        }
    }
}
setCurrentSidebarBtn();