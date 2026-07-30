// tests/Functional/src/main/java/com/functional/todo/NewListPage.java
package com.functional.todo;

import org.openqa.selenium.By;
import org.openqa.selenium.WebDriver;
import org.openqa.selenium.WebElement;

/**
 * POM page object model
 **/
public class NewListPage {
    private final WebDriver driver;
    private final By titleLocator = By.cssSelector("head > title");
    private final By bootstrapCSSLocator = By.cssSelector("head > link:first-of-type");
    private final By bootstrapJSLocator = By.cssSelector("head > script:first-of-type");
    private final By headLocator = By.cssSelector("head:first-of-type");
    private final By headerLocator = By.cssSelector("body > header:first-of-type");
    private final By mainLocator = By.cssSelector("body > main:first-of-type");
    private final By footerLocator = By.cssSelector("body > footer:last-of-type");

    // form elements locator
    private final By newListForm = By.cssSelector("#newListForm");
    private final By listNameInput = By.cssSelector("#listName");
    private final By submitButton = By.cssSelector("#submitButton");

    public NewListPage(WebDriver driver) {
        this.driver = driver;
    }

    public WebElement getTitle() {
        return driver.findElement(titleLocator);
    }

    public WebElement getBootstrapCSS() {
        return driver.findElement(bootstrapCSSLocator);
    }

    public WebElement getBootstrapJS() {
        return driver.findElement(bootstrapJSLocator);
    }

    public WebElement getHead() {
        return driver.findElement(headLocator);
    }

    public WebElement getHeader() {
        return driver.findElement(headerLocator);
    }

    public WebElement getMain() {
        return driver.findElement(mainLocator);
    }

    public WebElement getFooter() {
        return driver.findElement(footerLocator);
    }

    public WebElement getNewListForm() {
        return driver.findElement(newListForm);
    }

    public WebElement getListNameInput() {
        return driver.findElement(listNameInput);
    }

    public WebElement getSubmitButton() {
        return driver.findElement(submitButton);
    }

    public void createList(String listName) {
        var input = getListNameInput();
        var btn = getSubmitButton();
        input.sendKeys(listName);
        btn.click();
    }
}
