<?php

/*
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

namespace TYPO3\CMS\Workspaces\Tests\Functional\DataHandling\Group\Publish;

use TYPO3\CMS\Workspaces\Tests\Functional\DataHandling\Group\AbstractActionTestCase;

/**
 * Functional test for the DataHandler
 */
class ActionTest extends AbstractActionTestCase
{
    /**
     * @var string
     */
    protected $assertionDataSetDirectory = 'typo3/sysext/workspaces/Tests/Functional/DataHandling/Group/Publish/DataSet/';

    /**
     * Relations
     */

    /**
     * @test
     * See DataSet/addElementRelation.csv
     */
    public function addElementRelation()
    {
        parent::addElementRelation();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdFirst);
        $this->assertAssertionDataSet('addElementRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1', 'Element #2', 'Element #3'));
    }

    /**
     * @test
     * See DataSet/deleteElementRelation.csv
     */
    public function deleteElementRelation()
    {
        parent::deleteElementRelation();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdFirst);
        $this->assertAssertionDataSet('deleteElementRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1'));
        self::assertThat($responseSections, $this->getRequestSectionStructureDoesNotHaveRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #2', 'Element #3'));
    }

    /**
     * @test
     * See DataSet/changeElementSorting.csv
     */
    public function changeElementSorting()
    {
        parent::changeElementSorting();
        $this->actionService->publishRecord(self::TABLE_Element, self::VALUE_ElementIdFirst);
        $this->assertAssertionDataSet('changeElementSorting');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1', 'Element #2'));
    }

    /**
     * @test
     * See DataSet/changeElementRelationSorting.csv
     */
    public function changeElementRelationSorting()
    {
        parent::changeElementRelationSorting();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdFirst);
        $this->assertAssertionDataSet('changeElementRelationSorting');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1', 'Element #2'));
    }

    /**
     * @test
     * See DataSet/createContentNAddRelation.csv
     */
    public function createContentAndAddElementRelation()
    {
        parent::createContentAndAddElementRelation();
        $this->actionService->publishRecord(self::TABLE_Content, $this->recordIds['newContentId']);
        $this->assertAssertionDataSet('createContentNAddRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionHasRecordConstraint()
            ->setTable(self::TABLE_Content)->setField('header')->setValues('Testing #1'));
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . $this->recordIds['newContentId'])->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1'));
    }

    /**
     * @test
     * See DataSet/createContentNCreateRelation.csv
     */
    public function createContentAndCreateElementRelation()
    {
        parent::createContentAndCreateElementRelation();
        $this->actionService->publishRecords(
            [
                self::TABLE_Content => [$this->recordIds['newContentId']],
                self::TABLE_Element => [$this->recordIds['newElementId']],
            ]
        );
        $this->assertAssertionDataSet('createContentNCreateRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionHasRecordConstraint()
            ->setTable(self::TABLE_Content)->setField('header')->setValues('Testing #1'));
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . $this->recordIds['newContentId'])->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Testing #1'));
    }

    /**
     * @test
     * See DataSet/modifyElementOfRelation.csv
     */
    public function modifyElementOfRelation()
    {
        parent::modifyElementOfRelation();
        $this->actionService->publishRecord(self::TABLE_Element, self::VALUE_ElementIdFirst);
        $this->assertAssertionDataSet('modifyElementOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Testing #1', 'Element #2'));
    }

    /**
     * @test
     * See DataSet/modifyContentOfRelation.csv
     */
    public function modifyContentOfRelation()
    {
        parent::modifyContentOfRelation();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdFirst);
        $this->assertAssertionDataSet('modifyContentOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionHasRecordConstraint()
            ->setTable(self::TABLE_Content)->setField('header')->setValues('Testing #1'));
    }

    /**
     * @test
     * See DataSet/modifyBothSidesOfRelation.csv
     */
    public function modifyBothSidesOfRelation()
    {
        parent::modifyBothSidesOfRelation();
        $this->actionService->publishRecords(
            [
                self::TABLE_Content => [self::VALUE_ContentIdFirst],
                self::TABLE_Element => [self::VALUE_ElementIdFirst],
            ]
        );
        $this->assertAssertionDataSet('modifyBothSidesOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Testing #1', 'Element #2'));
        self::assertThat($responseSections, $this->getRequestSectionHasRecordConstraint()
            ->setTable(self::TABLE_Content)->setField('header')->setValues('Testing #1'));
    }

    /**
     * @test
     * See DataSet/deleteContentOfRelation.csv
     */
    public function deleteContentOfRelation()
    {
        parent::deleteContentOfRelation();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdLast);
        $this->assertAssertionDataSet('deleteContentOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionDoesNotHaveRecordConstraint()
            ->setTable(self::TABLE_Content)->setField('header')->setValues('Testing #1'));
    }

    /**
     * @test
     * See DataSet/deleteElementOfRelation.csv
     */
    public function deleteElementOfRelation()
    {
        parent::deleteElementOfRelation();
        $this->actionService->publishRecord(self::TABLE_Element, self::VALUE_ElementIdFirst);
        $this->assertAssertionDataSet('deleteElementOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureDoesNotHaveRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1'));
    }

    /**
     * @test
     * See DataSet/copyContentOfRelation.csv
     */
    public function copyContentOfRelation()
    {
        parent::copyContentOfRelation();
        $this->actionService->publishRecord(self::TABLE_Content, $this->recordIds['copiedContentId']);
        $this->assertAssertionDataSet('copyContentOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        // Referenced elements are not copied with the "parent", which is expected and correct
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . $this->recordIds['copiedContentId'])->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #2', 'Element #3'));
    }

    /**
     * @test
     * See DataSet/copyElementOfRelation.csv
     */
    public function copyElementOfRelation()
    {
        parent::copyElementOfRelation();
        $this->actionService->publishRecord(self::TABLE_Element, $this->recordIds['copiedElementId']);
        $this->assertAssertionDataSet('copyElementOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1'));
        // Referenced elements are not updated at the "parent", which is expected and correct
        self::assertThat($responseSections, $this->getRequestSectionStructureDoesNotHaveRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #1 (copy 1)'));
    }

    /**
     * @test
     * See DataSet/localizeContentOfRelation.csv
     */
    public function localizeContentOfRelation()
    {
        parent::localizeContentOfRelation();
        $this->actionService->publishRecord(self::TABLE_Content, $this->recordIds['localizedContentId']);
        $this->assertAssertionDataSet('localizeContentOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, self::VALUE_LanguageId, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdLast)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #2', 'Element #3'));
    }

    /**
     * @test
     * See DataSet/localizeElementOfRelation.csv
     */
    public function localizeElementOfRelation()
    {
        // Create and publish translated page first
        $translatedPageResult = $this->actionService->copyRecordToLanguage('pages', self::VALUE_PageId, self::VALUE_LanguageId);
        $this->actionService->publishRecord('pages', $translatedPageResult['pages'][self::VALUE_PageId]);
        parent::localizeElementOfRelation();
        $this->actionService->publishRecord(self::TABLE_Element, $this->recordIds['localizedElementId']);
        $this->assertAssertionDataSet('localizeElementOfRelation');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageId, self::VALUE_LanguageId, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdFirst)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('[Translate to Dansk:] Element #1', 'Element #2'));
    }

    /**
     * @test
     * See DataSet/moveContentOfRelationToDifferentPage.csv
     */
    public function moveContentOfRelationToDifferentPage()
    {
        parent::moveContentOfRelationToDifferentPage();
        $this->actionService->publishRecord(self::TABLE_Content, self::VALUE_ContentIdLast);
        $this->assertAssertionDataSet('moveContentOfRelationToDifferentPage');

        $responseSections = $this->getFrontendResponse(self::VALUE_PageIdTarget, 0, self::VALUE_BackendUserId, self::VALUE_WorkspaceId)->getResponseSections();
        self::assertThat($responseSections, $this->getRequestSectionStructureHasRecordConstraint()
            ->setRecordIdentifier(self::TABLE_Content . ':' . self::VALUE_ContentIdLast)->setRecordField(self::FIELD_ContentElement)
            ->setTable(self::TABLE_Element)->setField('title')->setValues('Element #2', 'Element #3'));
    }
}
