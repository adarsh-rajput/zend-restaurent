@echo off
set /p inp= Enter name of module in locarecase (no space), nothing to cancel 
if [%inp%] == [] GOTO :eof
call :FirstUp m_name %inp%

cd module
md %m_name%\config
cd %m_name%
type NUL > Module.php
type NUL > autoload_classmap.php
type NUL > config\module.config.php

md src\%m_name%\Controller
md view\%inp%\%inp%
type NUL > view\%inp%\%inp%\index.phtml
cd src\%m_name%
md Form
md Model

type NUL > Model\%m_name%.php
type NUL > Controller\%m_name%Controller.php
pause


:FirstUp
setlocal EnableDelayedExpansion
set "temp=%~2"
set "helper=##AABBCCDDEEFFGGHHIIJJKKLLMMNNOOPPQQRRSSTTUUVVWWXXYYZZ"
set "first=!helper:*%temp:~0,1%=!"
set "first=!first:~0,1!"
if "!first!"=="#" set "first=!temp:~0,1!"
set "temp=!first!!temp:~1!"
(
    endlocal
    set "m_name=%temp%"
    goto :eof
)