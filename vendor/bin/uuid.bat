@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../ramsey/uuid/bin/uuid
php "%BIN_TARGET%" %*
