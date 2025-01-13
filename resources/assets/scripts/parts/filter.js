export class Filter {
    init() {
        // $(document).ready(function () {
        //     const projectContainer = $(".project-container");
        //     const tagButtons = $(".tag-button");
        //     const projectBlocks = $(".project");
        //     const loadMoreButton = $("#loadMoreButtonSmall");

        //     let selectedTag = "all";
        //     let currentPage = 1;
        //     const itemsPerPage = 4;

        //     function filterProjectsByTag(tag) {
        //         selectedTag = tag;
        //         currentPage = 1; 
      
        //         projectContainer.empty();

        //         const filteredProjectBlocks = projectBlocks.filter(function () {
        //             const tags = $(this).attr("data-tags").split(",");
        //             return selectedTag === "all" || tags.includes(selectedTag);
        //         });

        //         showProjectsForPage(currentPage, filteredProjectBlocks);
        //         updateLoadMoreButton(filteredProjectBlocks);
        //     }

        //     function showProjectsForPage(pageNumber, projectBlocks) {
        //         const startIndex = (pageNumber - 1) * itemsPerPage;
        //         const endIndex = Math.min(startIndex + itemsPerPage, projectBlocks.length);

        //         for (let i = startIndex; i < endIndex; i++) {
        //             projectContainer.append(projectBlocks.eq(i).clone());
        //         }
        //     }

        //     function updateLoadMoreButton(filteredProjectBlocks) {
        //         const visibleProjectCount = filteredProjectBlocks.length;

        //         if (visibleProjectCount <= currentPage * itemsPerPage) {
        //             loadMoreButton.hide();
        //         } else {
        //             loadMoreButton.show();
        //         }
        //     }

        //     function loadMoreProjects() {
        //         currentPage++;
        //         const filteredProjectBlocks = projectBlocks.filter(function () {
        //             const tags = $(this).attr("data-tags").split(",");
        //             return selectedTag === "all" || tags.includes(selectedTag);
        //         });

        //         showProjectsForPage(currentPage, filteredProjectBlocks);
        //         updateLoadMoreButton(filteredProjectBlocks);
        //     }

        //     tagButtons.on("click", function () {
        //         tagButtons.removeClass("active");
        //         $(this).addClass("active");
        //         const tag = $(this).attr("data-tag");
        //         filterProjectsByTag(tag);
        //     });

        //     loadMoreButton.on("click", loadMoreProjects);

        //     filterProjectsByTag(selectedTag);
        // });
    }
}