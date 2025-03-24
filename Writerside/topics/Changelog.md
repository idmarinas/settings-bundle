# Changelog

## 1.0.0 - {(2025-03-DD)}

## Release highlights

This is the initial version of %project%.

### Added

**Admin Controllers**

* _Added_ `AbstractSettingCrudController` a basic admin controller for **Settings** in EasyAdminBundle
* _Added_ `AbstractSettingDomainCrudController` a basic admin controller for **Settings Domain** in EasyAdminBundle

**Entities**

* _Added_ `AbstractSetting` basic **Setting** entity
* _Added_ `AbstractSettingDomain` basic **Setting Domain** entity

**Repositories**

* _Added_ `AbstractSettingRepository` base repository for **Setting** entity
* _Added_ `AbstractSettingDomainRepository` base repository for **Setting Domain** entity

**Entity Listeners**

* Added `SettingListener` listener that invalidate or create a cache for `Setting` entity
* Added `SettinDomainListener` listener that invalidate or create a cache for `SettingDomain` entity
  ```php
    // Example
    #[ORM\Entity]
    #[ORM\EntityListeners([SettingListener::class])]
    class Setting extends AbstractSetting
    {
      public const string ENTITY_NAME = 'setting';
    }
    ``` 
