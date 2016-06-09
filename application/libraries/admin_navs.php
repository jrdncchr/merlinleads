<?php

if (!defined('BASEPATH'))
    exit('No direct access is allowed!');

class Admin_Navs {

    public function get_navs($main) {

        switch($main) {
            case "Templates":
                $nav = array(
                    "nav" => array(
                        array("title" => "Modules 1 Templates", "url" => "admin/templates", "id" => "m1TemplatesTopLink"),
                        array("title" => "Modules 2 Templates", "url" => "#", "id"=> "m2TemplatesTopLink",
                            "sub-nav" => array(
                                array("title" => "Categories", "url" => "admin2/category", "id" => "categoryTopLink"),
                                array("title" => "Sub Categories", "url" => "admin2/sub_category", "id" => "subCategoryTopLink"),
                            )
                        ),
                        array("title" => "Headline & Call to Actions", "url" => "admin/hs_cta", "id" => "hsCtaTopLink")
                    )
                );
                break;
            case "Short Codes":
                $nav = array(
                    "nav" => array(
                        array("title" => "Short Codes", "url" => "admin/short_codes", "id" => "shortCodesTopLink")
                    )
                );
                break;
            case "Users":
                $nav = array(
                    "nav" => array(
                        array("title" => "Users", "url" => "admin/users", "id" => "usersTopLink")
                    )
                );
                break;

            case "Packages":
                $nav = array(
                    "nav" => array(
                        array("title" => "Packages", "url" => "admin/packages", "id" => "packagesTopLink"),
                        array("title" => "Packages Features", "url" => "admin/packages_features", "id" => "packagesFeaturesTopLink"),
                        array("title" => "Features", "url" => "admin/features", "id" => "featuresTopLink")
                    )
                );
                break;

            case "Modules":
                $nav = array(
                    "nav" => array(
                        array("title" => "Modules", "url" => "admin/modules", "id" => "modulesTopLink"),
                        array("title" => "Slideshare", "url" => "admin/slideshare", "id" => "slideshareTopLink")
                    )
                );
                break;
            case "SEOBuilder":
                $nav = array(
                    "nav" => array(
                        array("title" => "Templates", "url" => "admin2/seo_builder_template", "id" => "seoBuilderTemplateTopLink"),
                        array("title" => "Cities", "url" => "admin2/seo_builder_city", "id" => "seoBuilderCityTopLink"),
                        array("title" => "AS Categories", "url" => "admin2/seo_builder_as_category", "id" => "seoBuilderAsCategoriesTopLink"),
                        array("title" => "AS Inputs", "url" => "admin2/seo_builder_as_input", "id" => "seoBuilderAsInputsTopLink"),
                        array("title" => "AS Options", "url" => "admin2/seo_builder_as_option", "id" => "seoBuilderAsOptionsTopLink")
                    )
                );
                break;

            case "Scheduler":
                $nav = array(
                    "nav" => array(
                        array("title" => "Merlin Categories", "url" => "admin/scheduler_merlin_category", "id" => "schedulerCategoriesTopLink"),
                        array("title" => "Merlin Posts", "url" => "admin/scheduler_merlin_post", "id" => "schedulerPostsTopLink"),
                        array("title" => "Blog Post Templates", "url" => "admin/scheduler_blog_post", "id" => "schedulerBlogPostTemplateTopLink")
                    )
                );
                break;

            default:
                $nav = array();

        }

        return $nav;

    }

} 