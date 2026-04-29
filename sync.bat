@echo off
echo.
echo [1/3] Adding changes...
git add .
echo [2/3] Committing changes...
git commit -m "Auto-sync: %date% %time%"
echo [3/3] Pushing to GitHub...
git push origin main
echo.
echo Sync Complete!
pause
