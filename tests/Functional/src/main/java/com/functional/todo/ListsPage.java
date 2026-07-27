package com.functional.todo;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

import java.util.List;

public class ListsPage {
    private WebDriver driver;
    private final By navLinks = By.cssSelector("header > nav a[href]");
    private final By lists = By.cssSelector("#lists");
    private final By listNames = By.cssSelector("#lists > li a[href]:first-of-type > span");
    private final By numberOfTasksPerList = By.cssSelector("#lists > li > small:first-of-type");

    public ListsPage(WebDriver driver) {
        this.driver = driver;
    }

    public List<WebElement> getNavLinks() {
        return driver.findElements(navLinks);
    }

    public WebElement getListsContainer() {
        return driver.findElement(lists);
    }

    public List<WebElement> getListNames() {
        return driver.findElements(listNames);
    }

    public List<WebElement> getNumberOfTasksPerList() {
        return driver.findElements(numberOfTasksPerList);
    }
}
